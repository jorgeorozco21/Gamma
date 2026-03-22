<?php

namespace App\Http\Controllers;

use App\Imports\FilasImport;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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

        $columnasEsperadas = ['id_material','cantidad_total','id_laboratorio'];

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

        $datos = $contenido[0]->filter(function ($fila){
            return count(array_filter($fila->toArray())) >= 1;
        });

        // Comenzamos la validacion de las filas
        $index = 2;
        $datosValidados = [];
        foreach ($datos as $fila){
            $info = $fila->toArray();

            $validator = Validator::make($info, [
                "id_material" => "required|string|max:255",
                "cantidad_total" => "required|integer|min:1",
                "id_laboratorio" => "required|string|max:255"
            ],[
                "id_material.required" => "Fila {$index}: El Material es obligatorio",
                "id_material.max" => "Fila {$index}: El Nombre del Material no puede exceder los 255 caracteres",
                "cantidad_total.required" => "Fila {$index}: La Cantidad es obligatoria",
                "cantidad_total.integer" => "Fila {$index}: La Cantidad tiene que se un numero",
                "cantidad_total.min" => "Fila {$index}: La Cantidad minima es de 1",
                "id_laboratorio.required" => "Fila {$index}: El Laboratorio es obligatorio",
                "id_laboratorio.max" => "Fila {$index}: El Nombre del Laboratorio no puede exceder los 255 caracteres"
            ]);

            if ($info['id_material'] != null){
                $idMaterial =
                    DB::table("materiales as m")
                    ->select(
                        "m.id"
                    )
                    ->where("m.nombre","=",$info["id_material"])
                    ->first()
                ;

                if ($idMaterial){
                    $idMat = $idMaterial->id;
                    $info['id_material'] = $idMat;
                }else{
                    $validator->after(function ($validator) use ($index){
                        $validator->errors()->add('id_material', "Fila {$index}: El Material no existe.");
                    });
                }
            }

            if ($info['id_laboratorio'] != null){
                $idLaboratorio = 
                    DB::table('laboratorios as l')
                    ->select(
                        "l.id"
                    )
                    ->where("l.nombre","=",$info['id_laboratorio'])
                    ->first()
                ;

                if ($idLaboratorio){
                    $idLab = $idLaboratorio->id;
                    $info['id_laboratorio'] = $idLab;
                }else{
                    $validator->after(function ($validator) use ($index){
                        $validator->errors()->add('id_material', "Fila {$index}: El Laboratorio no existe.");
                    });
                }

            }

            if ($validator->fails()){
                $errores = array_merge($errores, $validator->errors()->all());
            }else{
                $info['cantidad_disponible'] = $info['cantidad_total'];
                $info['id_institucion'] = session('id_institucion');
                $datosValidados[] = $info;
            }

            $index++;
        }

        if (count($errores)){
            return redirect()->route('admin.inventario.index')->withErrors($errores, 'errores_excel');
        }

        foreach ($datosValidados as $fila){
            Inventario::create($fila);
        }

        return redirect()->route('admin.inventario.index')->with('success',"Informacion agregada correctamente");
    }
}
