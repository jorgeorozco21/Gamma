<?php

namespace App\Http\Controllers;

use App\Imports\FilasImport;
use App\Models\Laboratorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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
            return count(array_filter($fila->toArray())) >= 1;
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
                "tipo" => "required|string|in:prestamos,computo"
            ],[
                "nombre.required" => "Fila {$index}: El Nombre es obligatorio",
                "nombre.max" => "Fila {$index}: El Nombre no puede exceder los 255 caracteres",
                "tipo.required" => "Fila {$index}: El Tipo de Laboratorio es obligatorio",
                "tipo.in" => "Fila {$index}: El Tipo solo puede ser 'prestamos' o 'computo'"
            ]);

            $validator->after(function ($validator) use ($info, $index){
                if ($info['tipo'] == "prestamos" && $info['cantidad_computadoras'] != null){
                    $validator->errors()->add('cantidad_computadoras', "Fila {$index}: Un Laboratorio de tipo de Préstamos no puede tener computadoras.");
                }
            });

            if ($validator->fails()){
                $errores = array_merge($errores, $validator->errors()->all());
            }else{
                $info['id_institucion'] = session('id_institucion');
                $datosValidados[] = $info;
            }

            $index++;
        }

        if (count($errores)){
            return redirect()->route('admin.laboratorios.index')->withErrors($errores, 'errores_excel');
        }

        foreach ($datosValidados as $laboratorio){
            Laboratorio::create($laboratorio);
        }

        return redirect()->route('admin.laboratorios.index')->with('success',"Informacion agregada correctamente");
    }
}
