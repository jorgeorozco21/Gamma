<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArchivoUsuariosExport implements WithMultipleSheets, WithEvents
{
    
    public function sheets(): array
    {
        return [
            'Datos' => new DatosUsuarioExport(),
            'Grupos' => new GruposUsuarioExport()
        ];  
    }

    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {

                $spreadsheet = $event->writer->getDelegate();

                $grupos = $spreadsheet->getSheetByName('Grupos');

                if ($grupos) {
                    $grupos->setSheetState(Worksheet::SHEETSTATE_VERYHIDDEN);
                }
            }
        ];
    }
}
