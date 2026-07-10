<?php

namespace App\Http\Controllers;

use App\Exports\ArchivoMaterialesExport;
use App\Exports\InformacionMaterialesExport;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MaterialController extends Controller
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

        $materiales = 
            DB::table("materiales as m")
            ->select(
                "m.id",
                "m.nombre",
                "m.descripcion",
                "m.tipo"
            )
            ->where("m.id_institucion","=",session("id_institucion"))
            ->orderBy("m.nombre","ASC")
            ->orderBy("m.created_at","DESC")
            ->get()
        ;

        return view('Admin.Materiales.index', compact("materiales","admin"));
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
            "nombre" => "required|string|max:255",
            "descripcion" => "required|string|max:500"
        ],[
            "nombre.required" => "El Nombre es obligatorio",
            "nombre.max" => "El Nombre no puede exceder los 255 caracteres",
            "descripcion.required" => "La Descripcion es obligatoria",
            "descripcion.max" => "La descripcion no puede exceder los 500 caracteres"
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
            "nombre" => "required|string|max:255",
            "descripcion" => "required|string|max:500"
        ],[
            "nombre.required" => "El Nombre es obligatorio",
            "nombre.max" => "El Nombre no puede exceder los 255 caracteres",
            "descripcion.required" => "La Descripcion es obligatoria",
            "descripcion.max" => "La descripcion no puede exceder los 500 caracteres"
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

    public function archivoCarga(){

        return Excel::download(new ArchivoMaterialesExport, 'materiales.xlsx');
    } 

    public function exportarMateriales()
    {
        
        return Excel::download(new InformacionMaterialesExport(session('id_institucion')), 'informacion_materiales.xlsx');
    }
}
