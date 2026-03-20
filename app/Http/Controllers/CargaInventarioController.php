<?php

namespace App\Http\Controllers;

use App\Imports\FilasImport;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CargaInventarioController extends Controller
{
    public function cargaMasivaInventario(Request $request)
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
            return count(array_filter($fila->toArray())) == 3;
        });

        foreach ($datos as $fila){
            $idMat = 
                DB::table('materiales as m')
                ->select(
                    'm.id'
                )
                ->where('m.nombre','=',$fila['id_material'])
                ->first()
            ;

            $id = $idMat->id;

            $fila['id_material'] = $id;

            $idLab =
                DB::table('laboratorios as l')
                ->select(
                    'l.id'
                )
                ->where('l.nombre','=',$fila['id_laboratorio'])
                ->first()
            ;

            $id = $idLab->id;

            $fila['cantidad_disponible'] = $fila['cantidad_total'];
            $fila['id_laboratorio'] = $id;


            //return response()->json($fila);

            Inventario::create($fila->toArray());
        }

        return redirect()->route('admin.inventario.index')->with('success',"Informacion agregada correctamente");
    }
}
