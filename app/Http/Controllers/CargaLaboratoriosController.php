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
            'archivo' => 'required|file|mimes:csv,xlsx,xls,json'
        ],[
            "archivo.required" => "Tienes que subir un archivo",
            "archivo.mimes" => "Solo se permiten archivos .csv, .xlsx, .xls, .json"
        ]);

        $archivo = $request->file('archivo');
        $extension = $archivo->getClientOriginalExtension();
        $columnasEsperadas = ['nombre','tipo','cantidad_computadoras'];

        if ($extension == "csv" || $extension == "xlsx" || $extension == "xls"){

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

        }else if ($extension == "json"){

            $contenido = file_get_contents($archivo->getRealPath());

            $datos = json_decode($contenido, true);

            if ($datos === null) {
                return back()->withErrors([
                    'archivo' => 'Formato de archivo invalido'
                ]);
            }

            // Validar que cada registro tenga las claves necesarias
            foreach ($datos as $index => $laboratorio) {
                $missing = array_diff($columnasEsperadas, array_keys($laboratorio));
                if (!empty($missing)) {
                    return back()->withErrors([
                        'archivo' => "Formato de archivo invalido"
                    ]);
                }
            }
        }

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
