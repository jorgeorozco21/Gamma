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
        $columnasEsperadas = ['nombre_usuario','email','nombre','mantenimiento','encargado','normal','id_grupo'];

        $contenido = Excel::toCollection(new FilasImport, $archivo);
        $hoja = $contenido[0];
        $errores = [];

        if ($hoja->isEmpty()){
            throw ValidationException::withMessages([
                'archivo' => ["El Archivo Excel está vacío."]
            ]); 
        }

        // Convertir encabezados a minúsculas
        $columnas = $hoja->first()->keys()->map(fn($item) => strtolower($item))->toArray();
        $faltantes = array_diff($columnasEsperadas, $columnas);

        if (count($faltantes) > 0) {
            throw ValidationException::withMessages([
                'archivo' => ["Estructura inválida. Columnas faltantes: " . implode(', ', $faltantes)]
            ]);
        }

        // Filtrar filas válidas
        $datos = $hoja->filter(fn($fila) => count(array_filter($fila->toArray())) >= 1);

        // 1. OBTENER EL PREFIJO DE LA INSTITUCIÓN
        $institucion = DB::table("instituciones")
            ->where("id", session('id_institucion'))
            ->select("tag")
            ->first();
        $tag = $institucion ? $institucion->tag : '';

        // 2. OPTIMIZACIÓN CRÍTICA: Traer todos los grupos de una sola consulta indexados por su string único
        $gruposMapeados = DB::table("grupos")
            ->select('id', DB::raw("CONCAT(grado,'-',grupo,'-',nombre,'-',turno) as clave_grupo"))
            ->where('id_institucion',session('id_institucion'))
            ->get()
            ->pluck('id', 'clave_grupo') 
            ->toArray();

        // 3. OPTIMIZACIÓN CRÍTICA: Guardar registros en memoria temporal usando Hash Maps (Llaves) en lugar de in_array
        $usuariosEnArchivo = [];
        $correosEnArchivo = [];

        $index = 2;
        $datosValidados = [];

        foreach ($datos as $fila){
            $info = $fila->toArray();
            
            // Sanitización previa
            $nombreUsuario = isset($info['nombre_usuario']) ? trim($info['nombre_usuario']) : '';
            $email = isset($info['email']) ? strtolower(trim($info['email'])) : '';
            
            $info['mantenimiento'] = isset($info['mantenimiento']) ? strtolower(trim($info['mantenimiento'])) : 'no';
            $info['encargado'] = isset($info['encargado']) ? strtolower(trim($info['encargado'])) : 'no';
            $info['normal'] = isset($info['normal']) ? strtolower(trim($info['normal'])) : 'no';

            $validator = Validator::make($info, [
                'nombre_usuario' => "required|string|max:255|unique:usuarios,nombre_usuario",
                'email' => "required|email|max:255|unique:usuarios,email",
                'nombre' => "required|string|max:255",
                'mantenimiento' => "required|in:si,no",
                'encargado' => "required|in:si,no",
                'normal' => "required|in:si,no",
            ],[
                'nombre_usuario.required' => "Fila {$index}: El Nombre de Usuario es obligatorio",
                'nombre_usuario.max' => "Fila {$index}: El Nombre de Usuario no debe exceder los 255 caracteres",
                'nombre_usuario.unique' => "Fila {$index}: Nombre de Usuario ya existente en la base de datos",
                'email.required' => "Fila {$index}: El Email es obligatorio",
                'email.email' => "Fila {$index}: Email inválido",
                'email.max' => "Fila {$index}: El email no debe exceder los 255 caracteres",
                'email.unique' => "Fila {$index}: Email ya registrado en la base de datos",
                'nombre.required' => "Fila {$index}: El Nombre es obligatorio",
                'nombre.max' => "Fila {$index}: El Nombre no debe exceder los 255 caracteres",
                'mantenimiento.in' => "Fila {$index}: La columna Mantenimiento solo permite 'si' o 'no'",
                'encargado.in' => "Fila {$index}: La columna Encargado solo permite 'si' o 'no'",
                'normal.in' => "Fila {$index}: La columna Normal solo permite 'si' o 'no'"
            ]);

            $validator->after(function ($validator) use ($nombreUsuario, $email, $tag, $index, $info, $gruposMapeados, &$usuariosEnArchivo, &$correosEnArchivo) {
                // Duplicados dentro del mismo Excel (Uso de isset en lugar de in_array: O(1) vs O(N))
                if (isset($usuariosEnArchivo[$nombreUsuario])) {
                    $validator->errors()->add('nombre_usuario', "Fila {$index}: Nombre de Usuario ya repetido en este archivo.");
                } else if ($nombreUsuario !== '') {
                    $usuariosEnArchivo[$nombreUsuario] = true;
                }

                if (isset($correosEnArchivo[$email])) {
                    $validator->errors()->add('email', "Fila {$index}: Email ya repetido en este archivo.");
                } else if ($email !== '') {
                    $correosEnArchivo[$email] = true;
                }

                // Prefijo institucional
                if ($tag !== '' && !str_starts_with($nombreUsuario, $tag) && $nombreUsuario !== '') {
                    $validator->errors()->add('nombre_usuario', "Fila {$index}: El Nombre de Usuario debe iniciar con el prefijo '{$tag}'.");
                }

                // Validación de espacios
                if (str_contains($nombreUsuario, ' ')) {
                    $validator->errors()->add('nombre_usuario', "Fila {$index}: El Nombre de Usuario no puede contener espacios.");
                }

                // Validación de Roles lógicos y obtención de grupo mapeado sin queries internas
                $tieneRol = false;

                if ($info['mantenimiento'] === 'si') $tieneRol = true;
                if ($info['encargado'] === 'si') $tieneRol = true;
                
                if ($info['normal'] === 'si') {
                    $tieneRol = true;
                    $claveGrupo = $info['id_grupo'] ?? '';
                    
                    if (empty($claveGrupo)) {
                        $validator->errors()->add('id_grupo', "Fila {$index}: El Grupo es obligatorio para usuarios de tipo 'normal'.");
                    } elseif (!isset($gruposMapeados[$claveGrupo])) {
                        $validator->errors()->add('id_grupo', "Fila {$index}: El grupo '{$claveGrupo}' no existe en el sistema.");
                    }
                }

                if (!$tieneRol) {
                    $validator->errors()->add('tipo', "Fila {$index}: Debes seleccionar mínimo un tipo de usuario ('si' en mantenimiento, encargado o normal).");
                }
            });

            if ($validator->fails()){
                $errores = array_merge($errores, $validator->errors()->all());
            } else {
                $claveGrupo = $info['id_grupo'] ?? '';
                $datosValidados[] = [
                    'nombre_usuario'   => $nombreUsuario,
                    'email'            => $email,
                    'nombre'           => $info['nombre'],
                    'mantenimiento'    => $info['mantenimiento'] === 'si' ? '1' : '0',
                    'encargado'        => $info['encargado'] === 'si' ? '1' : '0',
                    'normal'           => $info['normal'] === 'si' ? '1' : '0',
                    'id_grupo'         => ($info['normal'] === 'si' && isset($gruposMapeados[$claveGrupo])) ? $gruposMapeados[$claveGrupo] : null,
                    'admin'            => '0',
                    'id_institucion'   => session('id_institucion'),
                ];
            }
            $index++;
        }

        if (count($errores)){
            return redirect()->route('admin.usuarios.index')->withErrors($errores, 'errores_excel');
        }

        // 4. TRANSACCIÓN MASIVA Y PREPARACIÓN DE CORREOS
        DB::transaction(function () use ($datosValidados) {
            foreach ($datosValidados as $data) {
                $contrasenaOriginal = Str::random(12);
                $data['contrasena'] = Hash::make($contrasenaOriginal);

                Usuario::create($data);

                Mail::to($data["email"])->queue(new UsuarioCreadoMail($data["nombre_usuario"], $contrasenaOriginal)->from('hola.labores.web@gmail.com','Administracion'));
            }
        });

        return redirect()->route('admin.usuarios.index')->with("success", 'Información agregada correctamente de forma masiva.');
    }
}
