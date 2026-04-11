<?php

namespace App\Http\Controllers;

use App\Exports\ArchivoInventarioExport;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InventarioController extends Controller
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
                "m.nombre"
            )
            ->where("m.id_institucion","=",session("id_institucion"))
            ->orderBy("m.nombre","ASC")
            ->orderBy("m.created_at","DESC")
            ->get()
        ;

        $laboratorios = 
            DB::table("laboratorios as l")
            ->select(
                "l.id",
                "l.nombre"
            )
            ->where("l.tipo","=","prestamos")
            ->where("l.id_institucion","=",session("id_institucion"))
            ->orderBy("l.nombre","ASC")
            ->orderBy("l.created_at","DESC")
            ->get()
        ;

        $inventarios = 
            DB::table("inventarios as i")
            ->join("materiales as m","m.id","=","i.id_material")
            ->join("laboratorios as l","l.id","=","i.id_laboratorio")
            ->select(
                "i.id",
                "m.nombre as nombreMaterial",
                "i.cantidad_total",
                'i.cantidad_disponible',
                "l.nombre as nombreLaboratorio"
            )
            ->where("l.id_institucion","=",session("id_institucion"))
            ->orderBy("l.nombre","ASC")
            ->orderBy("m.nombre","ASC")
            ->orderBy("i.created_at","DESC")
            ->get()
        ;

        return view('Admin.Inventario.index', compact("materiales","laboratorios","inventarios","admin"));
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
            "cantidad_total" => "required|integer|min:1"
        ],[
            "cantidad_total.required" => "La Cantidad es obligatoria",
        ]);

        $datosInventario['cantidad_disponible'] = $datosInventario['cantidad_total'];

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
            "cantidad_total" => "required|integer|min:1"
        ],[
            "cantidad_total.required" => "La Cantidad es obligatoria",
        ]);

        $request["cantidad_disponible"] =  $request["cantidad_disponible"] + ($request["cantidad_total"] - $request["cantidad_total_anterior"]);

        $datosInventario = $request->except("_token","_method","cantidad_total_anterior");

        Inventario::where("id","=",$id)->update($datosInventario);

        return redirect()->route('admin.inventario.index')->with("success",'Informacion editada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventario = Inventario::findOrFail($id);

        if ($inventario->cantidad_disponible != $inventario->cantidad_total){
            return redirect()->route('admin.inventario.index')->with("error",'No se puede borrar un invetario si la cantidad total no es igual a la disponible');
        }

        $inventario->delete();

        return redirect()->route('admin.inventario.index')->with("success",'Informacion borrada correctamente');
    }

    public function archivoCarga()
    {
        return Excel::download(new ArchivoInventarioExport(), 'inventario.xlsx');
    }
}
