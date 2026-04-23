<?php

namespace App\Http\Controllers;

use App\Models\AuditoriaComputo;
use App\Models\Computadora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComputadoraController extends Controller
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
        //
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
        $computadora = Computadora::findOrFail($id);

        $computadora->estado = ($computadora->estado == 'activo')?'inactivo':'activo';

        $computadora->save();

        return response()->json('todo bien');
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

    public function reemplazar(string $id)
    {
        $computadora = Computadora::findOrFail($id);

        $computadora->estado = 'activo';

        $computadora->save();

        DB::table('solicitudes_computo as s')
        ->where('s.id_computadora','=',$id)
        ->delete();

        return response()->json('todo bien');
    }

    public function crearComputadora(string $id){
        $total = DB::table('computadoras')
        ->where('id_laboratorio', $id)
        ->count();

        $info = [
            'numero_computadora' => $total + 1,
            'estado' => 'activo',
            'id_laboratorio' => $id
        ];

        Computadora::create($info);

        return response()->json('todo bien');
    }

    public function sinFuncionamiento(string $id, Request $request){
        $datos = $request->except('_token','_method');

        AuditoriaComputo::create($datos);

        $computadora = Computadora::findOrFail($id);

        $computadora->estado = 'inactivo';

        $computadora->save();

        return response()->json('todo bien');
    }
}
