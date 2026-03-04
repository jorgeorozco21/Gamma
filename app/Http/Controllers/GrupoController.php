<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrupoController extends Controller
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
                "l.Nombre"
            )
            ->where("l.ID_Institucion","=",session("id_institucion"))
            ->orderBy("l.Nombre","ASC")
            ->get()
        ;

        $grupos = 
            DB::table("grupos as g")
            ->select(
                "g.id",
                "g.Nombre",
                "g.Grado",
                "g.Grupo",
                "g.Laboratorios"
            )
            ->where("g.ID_Institucion","=",session("id_institucion"))
            ->orderBy("g.Nombre","ASC")
            ->orderBy("g.created_at","DESC")
            ->get()
        ;

        return view('Admin.Grupos.index',compact("grupos","laboratorios"));
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
        $datosGrupo = $request->except("_token");

        $request->validate([
            "Nombre" => "required|string|max:255",
            "Grado" => "required|string|max:255",
            "Grupo" => "required|string|max:255",
            "Laboratorios" => "required"
        ],[
            "Nombre.required" => "El Nombre es obligatorio",
            "Nombre.max" => "El Nombre no puede exceder los 255 caracteres",
            "Grado.required" => "El Grado es obligatorio",
            "Grado.max" => "El Grado no puede exceder los 255 caracteres",
            "Grupo.required" => "El Grupo es obligatorio",
            "Grupo.max" => "El Grupo no puede exceder los 255 caracteres",
            "Laboratorios.required" => "Debes seleccionar minimo un laboratorio"
        ]);

        Grupo::create($datosGrupo);

        return redirect()->route('admin.grupos.index')->with("success",'Grupo creado correctamente');

        //return response()->json($datosGrupo);
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
        $datosGrupo = $request->except("_token","_method");

        $request->validate([
            "Nombre" => "required|string|max:255",
            "Grado" => "required|string|max:255",
            "Grupo" => "required|string|max:255",
            "Laboratorios" => "required"
        ],[
            "Nombre.required" => "El Nombre es obligatorio",
            "Nombre.max" => "El Nombre no puede exceder los 255 caracteres",
            "Grado.required" => "El Grado es obligatorio",
            "Grado.max" => "El Grado no puede exceder los 255 caracteres",
            "Grupo.required" => "El Grupo es obligatorio",
            "Grupo.max" => "El Grupo no puede exceder los 255 caracteres",
            "Laboratorios.required" => "Debes seleccionar minimo un laboratorio"
        ]);

        Grupo::where("id","=",$id)->update($datosGrupo);

        return redirect()->route('admin.grupos.index')->with("success",'Informacion editada correctamente');

        //return response()->json($datosGrupo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $grupo = Grupo::findOrFail($id);

        $grupo->delete();

        return redirect()->route('admin.grupos.index')->with('success',"Grupo borrado correctamente");
    }
}
