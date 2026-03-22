<?php

namespace App\Http\Controllers;

use App\Imports\FilasImport;
use App\Mail\UsuarioCreadoMail;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CargaUsuariosController extends Controller
{
    public function cargaMasivaUsuarios(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls'
        ],[
            "archivo.required" => "Tienes que subir un archivo",
            "archivo.mimes" => "Solo se permiten archivos .xlsx, .xls"
        ]);

        $archivo = $request->file('archivo');
        $archivo = $request->file('archivo');
        $columnasEsperadas = ['nombre_usuario','email','nombre','mantenimiento','encargado','normal','id_grupo'];

        $contenido = Excel::toCollection(new FilasImport, $archivo);
        $hoja = $contenido[0];
        $errores = [];

        if ($hoja->isEmpty()){
            throw ValidationException::withMessages([
                'archivo' => ["El Archivo Excel está vacio."]
            ]); 
        }

        // Convertir encabezados del usuario a minusculas
        $columnas = $hoja->first()->keys()->map(function($item) {
            return strtolower($item);
        })->toArray();

        // Validamos las columnas sin imporar el orden y la mayuculas y minusuclas
        $faltantes = array_diff($columnasEsperadas, $columnas);

        if (count($faltantes) > 0) {
            throw ValidationException::withMessages([
                'archivo' => ["Estructura inválida. Columnas faltantes: " . implode(', ', $faltantes)]
            ]);
        }

        // Obtenemos todas las columnas que tengan minimo una columna llena
        $datos = $hoja->filter(function ($fila){
            return count(array_filter($fila->toArray())) >= 1;
        });

        $institucion = 
            DB::table("instituciones as i")
            ->select(
                "i.tag"
            )
            ->where("i.id","=",session('id_institucion'))
            ->first()
        ;

        $tag = $institucion->tag;
        $index = 2;
        $datosValidados = [];
        $correos = [];
        $usuarios = [];
        foreach ($datos as $fila){
            $info = $fila->toArray();
            $nombreUsuario = $info['nombre_usuario'] ?? '';
            $info['mantenimiento'] = strtolower($info['mantenimiento']);
            $info['encargado'] = strtolower($info['encargado']);
            $info['normal'] = strtolower($info['normal']);
            $band = false;

            $validator = Validator::make($info, [
                'nombre_usuario' => "required|string|max:255|unique:usuarios,nombre_usuario",
                'email' => "required|email|max:255|unique:usuarios,email",
                'nombre' => "required|string|max:255",
                'mantenimiento' => "required|in:si,no",
                'encargado' => "required|in:si,no",
                'normal' => "required|in:si,no",
            ],[
                'nombre_usuario.required' => "Fila {$index}: El Nombre de Usuario es obligatorio",
                'nombre_usuario.max' => "Fila {$index}: El Nombre de Usuario de debe de exceder los 255 caracteres",
                'nombre_usuario.unique' => "Fila {$index}: Nombre de Usuario ya existente",
                'email.required' => "Fila {$index}: El Email es obligatorio",
                'email.email' => "Fila {$index}: Email invalido",
                'email.max' => "Fila {$index}: El email no debe exceder los 255 caracteres",
                'email.unique' => "Fila {$index}: Email ya registrado",
                'nombre.required' => "Fila {$index}: El Nombre es obligatorio",
                'nombre.max' => "Fila {$index}: El Nombre no debe de exceder los 255 caracteres",
                'mantenimiento.required' => "Fila {$index}: Tienes que indicar si el Usuario puede acceder a las funciones de un Usuario de Mantenimiento",
                'mantenimiento.in' => "Fila {$index}: La columna de Mantenimiento solo permite como respuesta si o no",
                'encargado.required' => "Fila {$index}: Tienes que indicar si el Usuario puede acceder a las funciones de un Usuario de Encargado",
                'encargado.in' => "Fila {$index}: La columna de Encargado solo permite como respuesta si o no",
                'normal.required' => "Fila {$index}: Tienes que indicar si el Usuario puede acceder a las funciones de un Usuario Normal",
                'normal.in' => "Fila {$index}: La columna de Normal solo permite como respuesta si o no"
            ]);

            if (in_array($info['nombre_usuario'], $usuarios)){
                $validator->after(function ($validator) use ($index){
                    $validator->errors()->add('nombre_usuario', "Fila {$index}: Nombre de Usuario ya usado en este archivo.");
                });
            }else{
                $usuarios[] = $info['nombre_usuario'];
            }

            // 1. Verificar si NO comienza con el tag de la institución
            if (!str_starts_with($nombreUsuario, $tag) && $info['nombre_usuario'] != null){
                $validator->after(function ($validator) use ($index, $tag){
                    $validator->errors()->add('nombre_usuario', "Fila {$index}: El Nombre de Usuario debe iniciar con el prefijo '{$tag}'.");
                });
            }

            // 2. Verificar si tiene espacios
            if (str_contains($nombreUsuario, ' ') && $info['nombre_usuario'] != null) {
                $validator->after(function ($validator) use ($index){
                    $validator->errors()->add('nombre_usuario', "Fila {$index}: El Nombre de Usuario no puede contener espacios.");
                });
            }

            if (in_array($info['email'], $correos)){
                $validator->after(function ($validator) use ($index){
                    $validator->errors()->add('email', "Fila {$index}: Email ya usado en este archivo.");
                });
            }else{
                $correos[] = $info['email'];
            }

            if ($info['mantenimiento'] == 'si'){
                $info['mantenimiento'] = "1";
                $band = true;
            }else if ($info['mantenimiento'] == 'no') $info['mantenimiento'] = "0";

            if ($info['encargado'] == 'si'){
                $info['encargado'] = "1";
                $band = true;
            }else if ($info['encargado'] == 'no') $info['encargado'] = "0";

            if ($info['normal'] == 'no'){
                $info['normal'] = "0";
                $info['id_grupo'] = null;
            }else if ($info['normal'] == 'si'){
                $band = true;
                if ($info['id_grupo'] == null){
                    $validator->after(function ($validator) use ($index){
                        $validator->errors()->add('id_grupo', "Fila {$index}: EL Grupo es obligatorio.");
                    });
                }else{
                    $grupo = 
                        DB::table("grupos as g")
                        ->select(
                            "g.id"
                        )
                        ->whereRaw("CONCAT(g.grado,'-',g.grupo,'-',g.nombre) = ?", [$info['id_grupo']])
                        ->first()
                    ;
    
                    if (!$grupo){
                        $validator->after(function ($validator) use ($info, $index){
                            $validator->errors()->add('id_grupo', "Fila {$index}: El grupo '{$info['id_grupo']}' no existe.");
                        });
                    }else{
                        $info['id_grupo'] = $grupo->id;
                        $info['normal'] = "1";
                    }
                }
            }

            if (!$band){
                $validator->after(function ($validator) use ($info, $index){
                    $validator->errors()->add('tipo', "Fila {$index}: Debes seleccionar minimo un tipo de usuario.");
                });
            }

            if ($validator->fails()){
                $errores = array_merge($errores, $validator->errors()->all());
            }else{
                $info['admin'] = "0";
                $info['id_institucion'] = session('id_institucion');
                $datosValidados[] = $info;
            }

            $index++;
        }

        if (count($errores)){
            return redirect()->route('admin.usuarios.index')->withErrors($errores, 'errores_excel');
        }

        foreach ($datosValidados as $usuario){
            $contrasena = Str::random(12);
            $contrasenaHash = Hash::make($contrasena);

            $usuario['contrasena'] = $contrasenaHash;

            Usuario::create($usuario);

            Mail::to($usuario["email"])->send(new UsuarioCreadoMail($usuario["nombre_usuario"],$contrasena)->from('jeduardoorozco06@gmail.com','Administracion'));
        }

        return redirect()->route('admin.usuarios.index')->with("success",'Informacion agregada correctamente');
    }
}
