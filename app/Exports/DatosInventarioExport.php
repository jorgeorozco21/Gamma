<?php

namespace App\Exports;

use App\Models\Laboratorio;
use App\Models\Material;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Protection;

class DatosInventarioExport implements FromCollection, WithEvents, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            ["id_material","cantidad_total","id_laboratorio"]
        ]);
    }

    public function title(): string
    {
        return 'Datos';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $evento){
                $hoja = $evento->sheet->getDelegate();
                $id_institucion = session('id_institucion');

                $cantMateriales = Material::where("id_institucion", $id_institucion)->count() + 1;
                $cantLabs = Laboratorio::where("id_institucion", $id_institucion)->count() + 1;

                for ($fila = 2; $fila <= 1000; $fila++) {
                    $valMat = new DataValidation();
                    $valMat->setType(DataValidation::TYPE_LIST)
                            ->setAllowBlank(false)
                            ->setShowDropDown(true)
                            ->setFormula1("='Materiales'!\$B\$2:\$B\${$cantMateriales}");
                    $hoja->getCell("A{$fila}")->setDataValidation($valMat);

                    $valLab = new DataValidation();
                    $valLab->setType(DataValidation::TYPE_LIST)
                            ->setAllowBlank(false)
                            ->setShowDropDown(true)
                            ->setFormula1("='Laboratorios'!\$B\$2:\$B\${$cantLabs}");
                    $hoja->getCell("C{$fila}")->setDataValidation($valLab);
                }

                $hoja->getColumnDimension('A')->setWidth(40); // Ancho de 30 para la columna A
                $hoja->getColumnDimension('B')->setAutoSize(true); // Auto-ajuste para la columna B
                $hoja->getColumnDimension('C')->setWidth(40); // Ancho de 40 para la columna C
                
                // 1. Configurar la protección
                $proteccion = $hoja->getProtection();
                $proteccion->setSheet(true); 

                // 3. Desbloquear el rango de entrada de datos (A2:C1000)
                $hoja->getStyle('A2:C1000')->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);
            }
        ];
    }
}
