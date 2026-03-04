<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materiales = 
            DB::table("materiales as m")
            ->select(
                "m.id",
                "m.Nombre",
                "m.Descripcion",
                "m.Tipo"
            )
            ->where("m.ID_Institucion","=",session("id_institucion"))
            ->orderBy("m.Nombre","ASC")
            ->orderBy("m.created_at","DESC")
            ->get()
        ;

        return view('Admin.Materiales.index', compact("materiales"));
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
        $datosMaterial = $request->except('_token');

        $request->validate([
            "Nombre" => "required|string|max:255",
            "Descripcion" => "required|string|max:500"
        ],[
            "Nombre.required" => "El Nombre es obligatorio",
            "Nombre.max" => "El Nombre no puede exceder los 255 caracteres",
            "Descripcion.required" => "La Descripcion es obligatoria",
            "Descripcion.max" => "La descripcion no puede exceder los 500 caracteres"
        ]);

        Material::create($datosMaterial);

        return redirect()->route('admin.materiales.index')->with("success",'Material creado correctamente');

        //return response()->json($datosMaterial);
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
        $datosMaterial = $request->except("_token","_method");

        $request->validate([
            "Nombre" => "required|string|max:255",
            "Descripcion" => "required|string|max:500"
        ],[
            "Nombre.required" => "El Nombre es obligatorio",
            "Nombre.max" => "El Nombre no puede exceder los 255 caracteres",
            "Descripcion.required" => "La Descripcion es obligatoria",
            "Descripcion.max" => "La descripcion no puede exceder los 500 caracteres"
        ]);

        Material::where("id","=",$id)->update($datosMaterial);

        return redirect()->route('admin.materiales.index')->with("success",'Informacion editada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::findOrFail($id);

        $material->delete();

        return redirect()->route('admin.materiales.index')->with("success",'Material borrado correctamente');
    }
}
