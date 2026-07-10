<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class InformacionLaboratoriosExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithChunkReading
{
    protected $idInstitucion;

    // Recibimos el ID de la institución por el constructor para evitar usar session() directo aquí
    public function __construct($idInstitucion)
    {
        $this->idInstitucion = $idInstitucion;
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
        return DB::table("laboratorios as l")
            ->select(
                'l.nombre',
                'l.tipo',
                'l.cantidad_computadoras'
            )
            ->where("l.id_institucion", $this->idInstitucion)
            ->orderBy('l.tipo', 'asc')
            ->orderBy('l.nombre', 'asc');
    }

    /**
    * Definición de los encabezados del reporte de Excel
    */
    public function headings(): array
    {
        return [
            'Nombre del Laboratorio',
            'Tipo de Laboratorio',
            'Cantidad de Computadoras'
        ];
    }

    /**
    * Transformación de cada fila de la consulta
    * @param mixed $laboratorio
    */
    public function map($laboratorio): array
    {

        return [
            $laboratorio->nombre,
            $laboratorio->tipo,
            $laboratorio->cantidad_computadoras == 0 ? '0' : $laboratorio->cantidad_computadoras
        ];
    }
}
