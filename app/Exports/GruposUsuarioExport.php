<?php

namespace App\Exports;

use App\Models\Grupo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class GruposUsuarioExport implements FromCollection, WithTitle
{
    public function title(): string
    {
        return 'Grupos';
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Grupo::where('id_institucion','=',session('id_institucion'))->get()->map(function ($grupo){
            return [
                'id' => $grupo->id,
                'nombre' => "{$grupo->grado}-{$grupo->grupo}-{$grupo->nombre}"
            ];
        });
    }
}
