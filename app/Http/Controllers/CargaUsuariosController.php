<?php

namespace App\Http\Controllers;

use App\Imports\UsuariosImport;
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
    public function cargarMasivaUsuarios(Request $request)
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

            $contenido = Excel::toCollection(new UsuariosImport, $archivo);

            $datos = json_decode($contenido[0], true);

        }else if ($extension == "json"){

            $contenido = file_get_contents($archivo->getRealPath());

            $datos = json_decode($contenido, true);

        }

        foreach ($datos as $usuario){
            $contrasena = Str::random(12);
            $contrasenaHash = Hash::make($contrasena);

            $registro = [];
            if ($usuario["Grado"] == null || $usuario["Grupo"] == null || $usuario["Nombre_Especialidad"] == null){

                $registro = [
                    "Nombre_Usuario" => $usuario["Nombre_Usuario"],
                    "Email" => $usuario["Email"],
                    "Contrasena" => $contrasenaHash,
                    "Nombre" => $usuario["Nombre"],
                    "Tipo_Usuario" => $usuario["Tipo_Usuario"],
                    "ID_Institucion" => session("id_institucion")
                ];

            }else{

                $id = 
                    DB::table("grupos as g")
                    ->select(
                        "g.id"
                    )
                    ->where("g.Nombre","=",$usuario["Nombre_Especialidad"])->where("g.Grado","=",$usuario["Grado"])->where("g.Grupo","=",$usuario["Grupo"])
                    ->first()
                ;

                $id = $id->id;

                $registro = [
                    "Nombre_Usuario" => $usuario["Nombre_Usuario"],
                    "Email" => $usuario["Email"],
                    "Contrasena" => $contrasenaHash,
                    "Nombre" => $usuario["Nombre"],
                    "Tipo_Usuario" => $usuario["Tipo_Usuario"],
                    "ID_Grupo" => $id,
                    "ID_Institucion" => session("id_institucion")
                ];
            }

            Usuario::create($registro);

            Mail::to($registro["Email"])->send(new UsuarioCreadoMail($registro["Nombre_Usuario"],$contrasena)->from('jeduardoorozco06@gmail.com','Administracion'));

        }

        return redirect()->route('admin.usuarios.index')->with("success",'Informacion agregada correctamente');
    }

}
