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

class InformacionSolicitudesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithChunkReading
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
        return DB::table("solicitudes as s")
            ->leftJoin('auditoria as a','a.id_solicitud','=','s.id')
            ->select(
                's.id',
                's.info_usuario',
                's.info_material',
                's.created_at',
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
            ->where('s.info_usuario->idLaboratorio','=',$this->idLaboratorio)
            ->groupBy('s.id', 's.info_usuario', 's.info_material', 's.created_at')
            ->orderBy('s.created_at','desc');
    }

    /**
    * Definición de los encabezados del reporte de Excel
    */
    public function headings(): array
    {
        return [
            'ID Solicitud',
            'Nombre',
            'Email',
            'Infomarcion del Grupo',
            'Fecha',
            'Materiales Solicitados',
            'Auditorias'
        ];
    }

    /**
    * Transformación de cada fila de la consulta
    * @param mixed $solicitud
    */
    public function map($solicitud): array
    {
        $usuario = json_decode($solicitud->info_usuario);
        $grupo = "{$usuario->grado}° {$usuario->grupo} - {$usuario->nombreGrupo} - {$usuario->turno}";

        $materiales = json_decode($solicitud->info_material);

        $numeroFilaActual = count($this->modalesMateriales) + 2;
        $textoMateriales = "";
        foreach ($materiales as $mat){
            $textoMateriales .= "- Nombre: {$mat->nombre} Cantidad: {$mat->cantidad} \n";
        }

        $this->modalesMateriales[$numeroFilaActual] = trim($textoMateriales);

        $auditorias = $solicitud->lista_auditorias ? "- " . $solicitud->lista_auditorias : 'Sin movimientos de auditoría';

        $this->modalesAuditorias[$numeroFilaActual] = $auditorias;

        return [
            $solicitud->id,
            $usuario->nombre,
            $usuario->email,
            $grupo,
            $solicitud->created_at,
            'Ver materiales solicitados',
            'Ver auditorias de la solicitud',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow(); 
                
                for ($row=2;$row<=$highestRow;$row++) {

                    $cellE = 'F' . $row;
                    $sheet->getStyle($cellE)->getFont()->getColor()->setARGB('FF7B1FA3');
                    $sheet->getStyle($cellE)->getFont()->setBold(true);

                    $comment = $sheet->getComment($cellE);
    
                    $textoMaterialesFinal = "Materiales Solicitados:\n" . ($this->modalesMateriales[$row] ?? 'Sin materiales');
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

                    $cellF = 'G' . $row;
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
