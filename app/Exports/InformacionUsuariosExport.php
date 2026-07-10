<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class InformacionUsuariosExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithChunkReading
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
        return DB::table("usuarios as u")
            ->leftJoin('grupos as g', 'g.id', '=', 'u.id_grupo')
            ->select(
                'u.nombre_usuario',
                'u.email',
                'u.nombre', 
                'g.grado',
                'g.grupo',
                'g.nombre as nombre_grupo',
                'g.turno',
                'u.normal',
                'u.encargado',
                'u.mantenimiento'
            )
            ->where("u.admin", "!=", "1")
            ->where("u.id_institucion", $this->idInstitucion)
            ->orderBy('g.turno', 'asc')
            ->orderBy('g.grado', 'asc')
            ->orderBy('g.nombre', 'asc')
            ->orderBy('g.grupo', 'asc')
            ->orderBy('u.nombre', 'asc');
    }

    /**
    * Definición de los encabezados del reporte de Excel
    */
    public function headings(): array
    {
        return [
            'Nombre de Usuario',
            'Email',
            'Nombre',
            'Grupo',
            'Normal',
            'Encargado',
            'Mantenimiento'
        ];
    }

    /**
    * Transformación de cada fila de la consulta
    * @param mixed $usuario
    */
    public function map($usuario): array
    {
        $grupoCompleto = $usuario->grado ? "{$usuario->grado}° {$usuario->grupo} - {$usuario->nombre_grupo} - {$usuario->turno}" : '';

        return [
            $usuario->nombre_usuario,
            $usuario->email,
            $usuario->nombre,
            $grupoCompleto,
            $usuario->normal == 1 ? 'Sí' : 'No',
            $usuario->encargado == 1 ? 'Sí' : 'No',
            $usuario->mantenimiento == 1 ? 'Sí' : 'No',
        ];
    }
}