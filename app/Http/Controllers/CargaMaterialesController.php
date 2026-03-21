<?php

namespace App\Http\Controllers;

use App\Imports\FilasImport;
use App\Models\Material;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CargaMaterialesController extends Controller
{
    public function cargaMasivaMateriales(Request $request)
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

        foreach ($datos as $material){
            $material['tipo'] = strtolower($material['tipo']);
            $material['id_institucion'] = session('id_institucion');

            //return response()->json($material);
            Material::create($material->toArray());
        }

        return redirect()->route('admin.materiales.index')->with('success',"Informacion agregada correctamente");
    }
}
