<?php

namespace App\Exports;

use App\Models\Grupo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Protection;

class DatosUsuarioExport implements FromCollection, WithTitle, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect([
            ['nombre_usuario','email','nombre','mantenimiento','encargado','normal','id_grupo',]
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

                $cantGrupos = Grupo::where("id_institucion", $id_institucion)->count() + 1;

                for ($fila = 2; $fila <= 1000; $fila++) {
                    $matenimiento = new DataValidation();
                    $matenimiento->setType(DataValidation::TYPE_LIST)
                            ->setAllowBlank(false)
                            ->setShowDropDown(true)
                            ->setFormula1('"si,no"');
                    $hoja->getCell("D{$fila}")->setDataValidation($matenimiento);

                    $encargado = new DataValidation();
                    $encargado->setType(DataValidation::TYPE_LIST)
                            ->setAllowBlank(false)
                            ->setShowDropDown(true)
                            ->setFormula1('"si,no"');
                    $hoja->getCell("E{$fila}")->setDataValidation($encargado);

                    $normal = new DataValidation();
                    $normal->setType(DataValidation::TYPE_LIST)
                            ->setAllowBlank(false)
                            ->setShowDropDown(true)
                            ->setFormula1('"si,no"');
                    $hoja->getCell("F{$fila}")->setDataValidation($normal);

                    $valGrupo = new DataValidation();
                    $valGrupo->setType(DataValidation::TYPE_LIST)
                            ->setAllowBlank(false)
                            ->setShowDropDown(true)
                            ->setFormula1("='Grupos'!\$B\$1:\$B\${$cantGrupos}");
                    $hoja->getCell("G{$fila}")->setDataValidation($valGrupo);
                }

                $hoja->getColumnDimension('A')->setWidth(35); // Ancho de 35 para la columna A
                $hoja->getColumnDimension('B')->setWidth(35); // Ancho de 35 para la columna B
                $hoja->getColumnDimension('C')->setWidth(50); // Ancho de 50 para la columna C
                $hoja->getColumnDimension('D')->setAutoSize(true); // Ancho automatico de la columna D
                $hoja->getColumnDimension('E')->setAutoSize(true); // Ancho automatico de la columna E
                $hoja->getColumnDimension('F')->setAutoSize(true); // Ancho automatico de la columna F
                $hoja->getColumnDimension('G')->setWidth(40); // Ancho de 40 para la columna G

                
                // 1. Configurar la protección
                $proteccion = $hoja->getProtection();
                $proteccion->setSheet(true); 

                // 3. Desbloquear el rango de entrada de datos (A2:C1000)
                $hoja->getStyle('A2:G1000')->getProtection()->setLocked(Protection::PROTECTION_UNPROTECTED);
            }
        ];
    }
}
