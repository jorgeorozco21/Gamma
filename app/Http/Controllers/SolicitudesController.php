<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $infoSolicitud =  $request->except('_token','_method');

        foreach ($infoSolicitud['info_material'] as $material){
            $cant = Inventario::find($material['id']);

            if ($material['cantidad'] > $cant->cantidad_disponible){
                return response()->json([
                    'error' => "Stock insuficiente para: {$material['nombre']}. disponible: {$cant->cantidad_disponible}"
                ], 422);
            }
        }

        foreach ($infoSolicitud['info_material'] as $material){
            $cant = Inventario::find($material['id']);

            $cant->cantidad_disponible -= $material['cantidad'];

            $cant->save();
        }

        Solicitud::create($infoSolicitud);

        return response()->json('Todo bien');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $materiales = $solicitud->info_material;

        foreach ($materiales as $material){
            $cant = Inventario::find($material['id']);

            $cant->cantidad_disponible += $material['cantidad'];

            $cant->save();
        }

        $solicitud->delete();
        
        return response()->json(['success' => true, 'message' => 'Eliminado correctamente']);
    }
}
