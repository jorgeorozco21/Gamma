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

        $contenido = Excel::toCollection(new FilasImport, $archivo);

        $datos = $contenido[0]->filter(function ($fila){
            return count(array_filter($fila->toArray())) >= 6;
        });

        foreach ($datos as $usuario){
            $contrasena = Str::random(12);
            $contrasenaHash = Hash::make($contrasena);

            $registro = [];
            if ($usuario['id_grupo'] == null){

                $registro = [
                    "nombre_usuario" => $usuario["nombre_usuario"],
                    "email" => $usuario["email"],
                    "contrasena" => $contrasenaHash,
                    "nombre" => $usuario["nombre"],
                    "admin" => "0",
                    "mantenimiento" => ($usuario["mantenimiento"] == "Si")?'1':'0',
                    "encargado" => ($usuario["encargado"] == "Si")?'1':'0',
                    "normal" => ($usuario["normal"] == "Si")?'1':'0',
                    "id_institucion" => session("id_institucion")
                ];

            }else{

                $id = 
                    DB::table("grupos as g")
                    ->select(
                        "g.id"
                    )
                    ->whereRaw("CONCAT(g.grado,'-',g.grupo,'-',g.nombre) = ?", [$usuario['id_grupo']])
                    ->first()
                ;

                $id = $id->id;

                $registro = [
                    "nombre_usuario" => $usuario["nombre_usuario"],
                    "email" => $usuario["email"],
                    "contrasena" => $contrasenaHash,
                    "nombre" => $usuario["nombre"],
                    "admin" => "0",
                    "mantenimiento" => ($usuario["mantenimiento"] == "Si")?'1':'0',
                    "encargado" => ($usuario["encargado"] == "Si")?'1':'0',
                    "normal" => ($usuario["normal"] == "Si")?'1':'0',
                    "id_grupo" => $id,
                    "id_institucion" => session("id_institucion")
                ];
            }

            Usuario::create($registro);

            Mail::to($registro["email"])->send(new UsuarioCreadoMail($registro["nombre_usuario"],$contrasena)->from('jeduardoorozco06@gmail.com','Administracion'));

        }

        return redirect()->route('admin.usuarios.index')->with("success",'Informacion agregada correctamente');

        //return response()->json($datos);
    }

}
