<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ArchivoLaboratoriosExport implements WithMultipleSheets
{

    public function sheets(): array
    {
        return [
            'Datos' => new DatosLaboratoriosExport()
        ];  
    }

}
