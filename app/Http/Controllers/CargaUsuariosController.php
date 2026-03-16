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
            'archivo' => 'required|file|mimes:csv,xlsx,xls,json'
        ],[
            "archivo.required" => "Tienes que subir un archivo",
            "archivo.mimes" => "Solo se permiten archivos .csv, .xlsx, .xls, .json"
        ]);

        $archivo = $request->file('archivo');
        $extension = $archivo->getClientOriginalExtension();

        if ($extension == "csv" || $extension == "xlsx" || $extension == "xls"){

            $contenido = Excel::toCollection(new FilasImport, $archivo);

            $datos = json_decode($contenido[0], true);

        }else if ($extension == "json"){

            $contenido = file_get_contents($archivo->getRealPath());

            $datos = json_decode($contenido, true);

        }

        foreach ($datos as $usuario){
            $contrasena = Str::random(12);
            $contrasenaHash = Hash::make($contrasena);

            $registro = [];
            if ($usuario["grado"] == null || $usuario["grupo"] == null || $usuario["nombre_especialidad"] == null){

                $registro = [
                    "nombre_usuario" => $usuario["nombre_usuario"],
                    "email" => $usuario["email"],
                    "contrasena" => $contrasenaHash,
                    "nombre" => $usuario["nombre"],
                    "admin" => "0",
                    "mantenimiento" => $usuario["mantenimiento"],
                    "encargado" => $usuario["encargado"],
                    "normal" => $usuario["normal"],
                    "id_institucion" => session("id_institucion")
                ];

            }else{

                $id = 
                    DB::table("grupos as g")
                    ->select(
                        "g.id"
                    )
                    ->where("g.nombre","=",$usuario["nombre_especialidad"])->where("g.grado","=",$usuario["grado"])->where("g.grupo","=",$usuario["grupo"])
                    ->first()
                ;

                $id = $id->id;

                $registro = [
                    "nombre_usuario" => $usuario["nombre_usuario"],
                    "email" => $usuario["email"],
                    "contrasena" => $contrasenaHash,
                    "nombre" => $usuario["nombre"],
                    "admin" => "0",
                    "mantenimiento" => $usuario["mantenimiento"],
                    "encargado" => $usuario["encargado"],
                    "normal" => $usuario["normal"],
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
