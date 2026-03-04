<?php

namespace App\Http\Controllers;

use App\Models\Laboratorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaboratorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laboratorios = 
            DB::table("laboratorios as l")
            ->select(
                "l.id",
                "l.Nombre",
                "l.Tipo",
                "l.Cantidad_Computadoras"
            )
            ->where("l.ID_Institucion","=",session("id_institucion"))
            ->orderBy("l.Nombre","ASC")
            ->orderBy("l.created_at","DESC")
            ->get()
        ;

        return view('Admin.Laboratorios.index', compact('laboratorios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datosLaboratorio = $request->except("_token");

        $request->validate([
            "Nombre" => "required|string|max:255",
            "Cantidad" => "integer|min:1"
        ],[
            "Nombre.required" => "El Nombre es obligatorio",
            "Nombre.max" => "El Nombre no puede exceder los 255 caracteres",
            "Cantidad.min" => "La Cantidad minima permitida es de 1"
        ]);

        if ($datosLaboratorio['Tipo'] == "Prestamos"){
            $datosLaboratorio['Cantidad_Computadoras'] = null;
        }

        Laboratorio::create($datosLaboratorio);

        return redirect()->route('admin.laboratorios.index')->with('success',"Laboratorio creado correctamente");

        //return response()->json($datosLaboratorio);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $datosLaboratorio = $request->except("_token","_method");

        $request->validate([
            "Nombre" => "required|string|max:255",
            "Cantidad" => "integer|min:1"
        ],[
            "Nombre.required" => "El Nombre es obligatorio",
            "Nombre.max" => "El Nombre no puede exceder los 255 caracteres",
            "Nombre.min" => "La Cantidad minima permitida es de 1"
        ]);

        $datosLaboratorio['Cantidad_Computadoras']  = (int)$datosLaboratorio['Cantidad_Computadoras'];

        if ($datosLaboratorio['Tipo'] == "Prestamos"){
            $datosLaboratorio['Cantidad_Computadoras'] = null;
        }

        Laboratorio::where("id","=",$id)->update($datosLaboratorio);

        return redirect()->route('admin.laboratorios.index')->with('success','Informacion editada correctamente');

        //return response()->json($datosLaboratorio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $laboratorio = Laboratorio::findOrFail($id);

        $laboratorio->delete();

        return redirect()->route('admin.laboratorios.index')->with('success',"Laboratorio borrado correctamente");
    }
}
