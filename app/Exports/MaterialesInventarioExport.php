<?php

namespace App\Exports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class MaterialesInventarioExport implements FromCollection, WithTitle
{
    public function title(): string
    {
        return 'Materiales';
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Material::where("id_institucion",'=',session('id_institucion'))->get()->map(function ($material){
            return [
                'id' => $material->id,
                'materiales' => $material->nombre
            ];
        });
    }
}
