<?php

namespace App\Http\Controllers;

use App\Imports\FilasImport;
use App\Models\Material;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CargaMaterialesController extends Controller
{
    public function cargaMasivaMateriales(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls'
        ],[
            "archivo.required" => "Tienes que subir un archivo.",
            "archivo.mimes" => "Solo se permiten archivos .xlsx, .xls"
        ]);

        $archivo = $request->file('archivo');
        $columnasEsperadas = ['nombre','descripcion','tipo'];

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
            return count(array_filter($fila->toArray())) >= 2;
        });
        
        // Comenzamos la validacion de las filas
        $index = 2;
        $datosValidados = [];
        foreach ($datos as $fila){
            $info = $fila->toArray();
            if (isset($info['tipo'])) {
                $info['tipo'] = strtolower(trim($info['tipo']));
            }

            $validator = Validator::make($info, [
                "nombre" => "required|string|max:255",
                "descripcion" => "required|string|max:500",
                "tipo" => "required|string|in:prestamos por unidad,prestamos por cantidad"
            ],[
                "nombre.required" => "Fila {$index}: El Nombre es obligatorio",
                "nombre.max" => "Fila {$index}: El Nombre no puede exceder los 255 caracteres",
                "descripcion.required" => "Fila {$index}: La Descripcion es obligatoria",
                "descripcion.max" => " Fila {$index}: La Descripcion no puede exceder los 500 caracteres",
                "tipo.required" => "Fila {$index}: El Tipo de Prestamo es obligatorio",
                "tipo.in" => "Fila {$index}: El Tipo solo puede ser 'prestamos por unidad' o 'prestamos por cantidad'"
            ]);

            if ($validator->fails()){
                $errores = array_merge($errores, $validator->errors()->all());
            }else{
                $info['id_institucion'] = session('id_institucion');
                $datosValidados[] = $info;
            }

            $index++;
        }

        if (count($errores)){
            return redirect()->route('admin.materiales.index')->withErrors($errores, 'errores_excel');
        }

        // return response()->json($datosValidados);
        foreach ($datosValidados as $material){
            Material::create($material);
        }

        return redirect()->route('admin.materiales.index')->with('success',"Informacion agregada correctamente");
    }
}