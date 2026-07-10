<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class InformacionReportesMaterialesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithChunkReading
{
    protected $idLaboratorio;

    protected $modalesMateriales = [];
    protected $modalesAuditorias = [];

    // Recibimos el ID de la institución por el constructor para evitar usar session() directo aquí
    public function __construct($idLaboratorio)
    {
        $this->idLaboratorio = $idLaboratorio;
    }

    public function chunkSize(): int
    {
        return 200; 
    }

    /**
    * Retorna el Query Builder de la consulta (AHORA SÍ, SIN ->get())
    */
    public function query()
    {
        return DB::table("reportes_materiales as rm")
            ->join('inventarios as i','i.id','=','rm.id_inventario')
            ->join('materiales as m','m.id','=','i.id_material')
            ->leftJoin('auditoria_reportes_materiales as a','a.id_reporte','=','rm.id')
            ->select(
                'rm.id',
                'rm.info_usuario',
                'm.nombre',
                'rm.cantidad',
                'rm.descripcion',
                'rm.created_at',
                DB::raw("STRING_AGG(
                    CONCAT(
                        'Nombre: ', a.info_usuario->>'nombre', 
                        ' (', a.info_usuario->>'email', ') ', 
                        ' - Estado: ', UPPER(a.estado), 
                        ' - Fecha: ', TO_CHAR(a.created_at, 'DD/MM/YYYY HH24:MI:SS')
                    ), 
                    '\n- '
                ) as lista_auditorias")
            )
            ->where('i.id_laboratorio','=',$this->idLaboratorio)
            ->groupBy(
                'rm.id', 
                'rm.info_usuario', 
                'm.nombre', 
                'rm.cantidad', 
                'rm.descripcion', 
                'rm.created_at'
            )
            ->orderBy('rm.created_at','desc');
    }

    /**
    * Definición de los encabezados del reporte de Excel
    */
    public function headings(): array
    {
        return [
            'ID Reporte',
            'Nombre',
            'Email',
            'Informacion del Reporte',
            'Fecha',
            'Auditorias'
        ];
    }

    /**
    * Transformación de cada fila de la consulta
    * @param mixed $reporte
    */
    public function map($reporte): array
    {
        $usuario = json_decode($reporte->info_usuario);

        $infoReporte = "- Nombre: {$reporte->nombre} \n";
        $infoReporte .= "- Cantidad: {$reporte->cantidad} \n";
        $infoReporte .= "- Descripcion: {$reporte->descripcion} \n";

        $numeroFilaActual = count($this->modalesMateriales) + 2;
        $this->modalesMateriales[$numeroFilaActual] = $infoReporte;

        $auditorias = $reporte->lista_auditorias ? "- " . $reporte->lista_auditorias : 'Sin movimientos de auditoría';

        $this->modalesAuditorias[$numeroFilaActual] = $auditorias;

        return [
            $reporte->id,
            $usuario->nombre,
            $usuario->email,
            'Ver informacion reporte',
            $reporte->created_at,
            'Ver auditorias del reporte'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow(); 
                
                for ($row=2;$row<=$highestRow;$row++) {

                    $cellE = 'D' . $row;
                    $sheet->getStyle($cellE)->getFont()->getColor()->setARGB('FF7B1FA3');
                    $sheet->getStyle($cellE)->getFont()->setBold(true);

                    $comment = $sheet->getComment($cellE);
    
                    $textoMaterialesFinal = "Informacion Reporte:\n" . ($this->modalesMateriales[$row] ?? 'Sin materiales');
                    $comment->getText()->createTextRun($textoMaterialesFinal);

                    $lineas = explode("\n", $textoMaterialesFinal);
                    $cantidadLineas = count($lineas);
                    
                    $maxCaracteres = 0;
                    foreach ($lineas as $linea) {
                        $maxCaracteres = max($maxCaracteres, mb_strlen($linea));
                    }

                    $anchoCalculado = ($maxCaracteres * 7.5) + 30;
                    $ancho = max(180, min(450, $anchoCalculado)); 
                    $alto = ($cantidadLineas * 16) + 35;

                    $comment->setWidth($ancho); 
                    $comment->setHeight($alto);

                    $cellF = 'F' . $row;
                    $sheet->getStyle($cellF)->getFont()->getColor()->setARGB('FF1F4E79');
                    $sheet->getStyle($cellF)->getFont()->setBold(true);

                    $commentF = $sheet->getComment($cellF);
                    $textoAuditoriaFinal = "Historial de Auditoría:\n" . ($this->modalesAuditorias[$row] ?? 'Sin información.');
                    $commentF->getText()->createTextRun($textoAuditoriaFinal);

                    $lineasF = explode("\n", $textoAuditoriaFinal);
                    $cantLineasF = count($lineasF);
                    
                    $maxCaracF = 0;
                    foreach ($lineasF as $linea) {
                        $maxCaracF = max($maxCaracF, mb_strlen($linea));
                    }

                    $anchoF = max(180, min(450, ($maxCaracF * 7.5) + 30)); 
                    $altoF = ($cantLineasF * 16) + 35;

                    $commentF->setWidth($anchoF); 
                    $commentF->setHeight($altoF);
                }
            },
        ];
    }
}
