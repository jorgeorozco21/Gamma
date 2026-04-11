<?php

namespace App\Http\Controllers;

use App\Models\AuditoriaReporteMaterial;
use App\Models\Inventario;
use Illuminate\Http\Request;

class AuditoriaReporteMaterialController extends Controller
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
        $datos = $request->except('_token', '_method');

        $datos['fecha'] = now();
    
        AuditoriaReporteMaterial::create($datos);

        return response()->json('todo bien');
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
        //
    }

    public function completarReporte(Request $request)
    {
        $datos = $request->except('_token', '_method', 'cantidad', 'id_inventario');

        $datos['fecha'] = now();

        $inventario = Inventario::findOrFail($request->id_inventario);

        $inventario['cantidad_disponible'] += (int) $request->cantidad;

        $inventario->save();
    
        AuditoriaReporteMaterial::create($datos);

        return response()->json('todo bien');
    }

    public function sinFuncionamiento(Request $request)
    {
        $datos = $request->except('_token', '_method', 'cantidad', 'id_inventario');

        $datos['fecha'] = now();

        $inventario = Inventario::findOrFail($request->id_inventario);

        $inventario['cantidad_total'] -= (int) $request->cantidad;

        $inventario->save();
    
        AuditoriaReporteMaterial::create($datos);

        return response()->json('todo bien');
    }
}
