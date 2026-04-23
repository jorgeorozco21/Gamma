<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\SolicitudEliminada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudEliminadaController extends Controller
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
        $infoSolicitud = $request->except('_token','_method');

        SolicitudEliminada::create($infoSolicitud);

        $solicitud = Solicitud::findOrFail($infoSolicitud['id_solicitud']);

        $materiales = $solicitud->info_material;

        foreach ($materiales as $m) {
            DB::table('inventarios')
                ->where('id', $m['id'])
                ->increment('cantidad_disponible', $m['cantidad']);
        }

        $solicitud->delete();

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
        $solicitud = SolicitudEliminada::findOrFail($id);

        $solicitud->delete();

        return response()->json(['success' => true, 'message' => 'Eliminado correctamente']);
    }
}
