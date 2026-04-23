<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditoriaController extends Controller
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
        $info = $request->except('_token','_method');

        if ($info['estado'] == 'recibido'){
            $solicitud = Solicitud::findOrFail($info['id_solicitud']);

            $materiales = $solicitud->info_material;

            foreach ($materiales as $m) {
                DB::table('inventarios')
                    ->where('id', $m['id'])
                    ->increment('cantidad_disponible', $m['cantidad']);
            }
        }
        
        Auditoria::create($info);

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
        //
    }
}
