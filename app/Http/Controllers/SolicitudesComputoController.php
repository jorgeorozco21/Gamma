<?php

namespace App\Http\Controllers;

use App\Models\SolicitudComputo;
use Illuminate\Http\Request;

class SolicitudesComputoController extends Controller
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
        $datos = $request->except('_token','_method');

        $datos['fecha'] = now();

        SolicitudComputo::create($datos);

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
        $solicitud = SolicitudComputo::findOrFail($id);

        $solicitud->delete();

        return response()->json('Todo bien');
    }
}
