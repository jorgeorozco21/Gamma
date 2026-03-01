<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
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
                "m.Nombre"
            )
            ->orderBy("m.Nombre","ASC")
            ->orderBy("m.created_at","DESC")
            ->get()
        ;

        $laboratorios = 
            DB::table("laboratorios as l")
            ->select(
                "l.id",
                "l.Nombre"
            )
            ->where("l.Tipo","=","Prestamos")
            ->orderBy("l.Nombre","ASC")
            ->orderBy("l.created_at","DESC")
            ->get()
        ;

        $inventarios = 
            DB::table("inventarios as i")
            ->join("materiales as m","m.id","=","i.ID_Material")
            ->join("laboratorios as l","l.id","=","i.ID_Laboratorio")
            ->select(
                "i.id",
                "m.Nombre as nombreMaterial",
                "i.Cantidad_Total",
                "l.Nombre as nombreLaboratorio"
            )
            ->orderBy("l.Nombre","ASC")
            ->orderBy("m.Nombre","ASC")
            ->orderBy("i.created_at","DESC")
            ->get()
        ;

        return view('Admin.Inventario.index', compact("materiales","laboratorios","inventarios"));
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
        $datosInventario = $request->except("_token");

        $request->validate([
            "Cantidad_Total" => "required|integer|min:1"
        ],[
            "Cantidad_Total.required" => "La Cantidad es obligatoria",
        ]);

        $datosInventario['Cantidad_Disponible'] = $datosInventario['Cantidad_Total'];

        Inventario::create($datosInventario);

        return redirect()->route('admin.inventario.index')->with("success",'Inventario creado correctamente');
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
        $request->validate([
            "Cantidad_Total" => "required|integer|min:1"
        ],[
            "Cantidad_Total.required" => "La Cantidad es obligatoria",
        ]);

        $request["Cantidad_Disponible"] =  $request["Cantidad_Disponible"] + ($request["Cantidad_Total"] - $request["Cantidad_Total_Anterior"]);

        $datosInventario = $request->except("_token","_method","Cantidad_Total_Anterior");

        Inventario::where("id","=",$id)->update($datosInventario);

        return redirect()->route('admin.inventario.index')->with("success",'Informacion editada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventario = Inventario::findOrFail($id);

        $inventario->delete();

        return redirect()->route('admin.inventario.index')->with("success",'Informacion borrada correctamente');
    }
}
