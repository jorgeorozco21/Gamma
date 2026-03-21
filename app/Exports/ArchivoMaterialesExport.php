<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ArchivoMaterialesExport implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            'Datos' => new DatosMaterialesExport()
        ];
    }

}
