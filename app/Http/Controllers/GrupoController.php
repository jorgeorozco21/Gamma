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
        $admin = 
            DB::table('usuarios as u')
            ->select(
                'u.nombre_usuario',
                'u.email'
            )
            ->where('u.id','=',session('id_usuario'))
            ->first()
        ;

        $laboratorios = 
            DB::table("laboratorios as l")
            ->select(
                "l.id",
                "l.nombre"
            )
            ->where("l.id_institucion","=",session("id_institucion"))
            ->orderBy("l.nombre","ASC")
            ->get()
        ;

        $grupos = 
            DB::table("grupos as g")
            ->select(
                "g.id",
                "g.nombre",
                "g.grado",
                "g.grupo",
                "g.laboratorios"
            )
            ->where("g.id_institucion","=",session("id_institucion"))
            ->orderBy("g.nombre","ASC")
            ->orderBy("g.created_at","DESC")
            ->get()
        ;

        return view('Admin.Grupos.index',compact("grupos","laboratorios","admin"));
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
            "nombre" => "required|string|max:255",
            "grado" => "required|string|max:255",
            "grupo" => "required|string|max:255",
            "laboratorios" => "required"
        ],[
            "nombre.required" => "El Nombre es obligatorio",
            "nombre.max" => "El Nombre no puede exceder los 255 caracteres",
            "grado.required" => "El Grado es obligatorio",
            "grado.max" => "El Grado no puede exceder los 255 caracteres",
            "grupo.required" => "El Grupo es obligatorio",
            "grupo.max" => "El Grupo no puede exceder los 255 caracteres",
            "laboratorios.required" => "Debes seleccionar minimo un laboratorio"
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
            "nombre" => "required|string|max:255",
            "grado" => "required|string|max:255",
            "grupo" => "required|string|max:255",
            "laboratorios" => "required"
        ],[
            "nombre.required" => "El Nombre es obligatorio",
            "nombre.max" => "El Nombre no puede exceder los 255 caracteres",
            "grado.required" => "El Grado es obligatorio",
            "grado.max" => "El Grado no puede exceder los 255 caracteres",
            "grupo.required" => "El Grupo es obligatorio",
            "grupo.max" => "El Grupo no puede exceder los 255 caracteres",
            "laboratorios.required" => "Debes seleccionar minimo un laboratorio"
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
