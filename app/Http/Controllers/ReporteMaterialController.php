<?php

namespace App\Http\Controllers;

use App\Models\ReporteMaterial;
use App\Models\Solicitud;
use Illuminate\Http\Request;

class ReporteMaterialController extends Controller
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
        $solicitud = Solicitud::findOrFail($request->id);

        $reporte = [
            'id_inventario' => $request->id_inventario,
            'info_usuario' => $request->info_usuario,
            'cantidad' => $request->cantidad,
            'descripcion' => $request->descripcion,
            'id_institucion' => session('id_institucion')
        ];

        if (!$request->info_material || $request->info_material == '[]'){
            $solicitud->delete();
        }else{
            $solicitud['info_material'] = $request->info_material;

            $solicitud->save();
        }

        ReporteMaterial::create($reporte);

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
}
