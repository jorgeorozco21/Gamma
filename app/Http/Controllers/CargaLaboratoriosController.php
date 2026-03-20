<?php

namespace App\Http\Controllers;

use App\Imports\FilasImport;
use App\Models\Laboratorio;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CargaLaboratoriosController extends Controller
{
    public function cargaMasivaLaboratorios(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls'
        ],[
            "archivo.required" => "Tienes que subir un archivo",
            "archivo.mimes" => "Solo se permiten archivos .xlsx, .xls"
        ]);

        $archivo = $request->file('archivo');
        $columnasEsperadas = ['nombre','tipo','cantidad_computadoras'];


        $contenido = Excel::toCollection(new FilasImport, $archivo);

        // Tomamos la primera fila como referencia de cabeceras
        $headers = $contenido[0][0]->keys()->toArray();

        // Validamos que todas las columnas esperadas estén presentes
        $missing = array_diff($columnasEsperadas, $headers);
        if (!empty($missing)) {
            return back()->withErrors([
                'archivo' => 'Formato de archivo invalido.'
            ]);
        }

        $datos = json_decode($contenido[0], true);

        foreach ($datos as $laboratorio){
            $laboratorio['tipo'] = strtolower($laboratorio['tipo']);

            if ($laboratorio['tipo'] == "prestamos") $laboratorio['cantidad_computadoras'] = null;

            $registro = [
                "nombre" => $laboratorio['nombre'],
                "tipo" => $laboratorio['tipo'],
                "cantidad_computadoras" => $laboratorio['cantidad_computadoras'],
                "id_institucion" => session('id_institucion')
            ];

            Laboratorio::create($registro);
        }

        return redirect()->route('admin.laboratorios.index')->with('success',"Informacion agregada correctamente");
    }
}
