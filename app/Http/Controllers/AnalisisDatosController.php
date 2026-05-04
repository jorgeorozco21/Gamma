<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalisisDatosController extends Controller
{
    public function erroresComunesComputo(Request $request)
    {
        $datos = 
            DB::table('solicitudes_computo as s')
            ->join('computadoras as c','c.id','=','s.id_computadora')
            ->select('s.tipo', DB::raw('count(s.id) as cantidad'))
            ->where('c.id_laboratorio', $request->id)
            ->groupBy('s.tipo')
            ->get()
        ;

        return response()->json([
            'labels' => $datos->pluck('tipo'),
            'series' => $datos->pluck('cantidad'), 
            'color' => '#7B1FA3',
            'graficos' => [
                'pastel' => 'Distribución de Errores',
                'barras' => 'Cantidad de Errores por Tipo'
            ]
        ]);
    }

    public function laboratoriosConMasComputadorasInactivas(Request $request)
    {
        $datos = 
            DB::table('laboratorios as l')
            ->leftJoin('computadoras as c', function($join) {
                $join->on('c.id_laboratorio','=','l.id')
                    ->where('c.estado','=','inactivo');
            })
            ->select(
                'l.nombre', 
                DB::raw('CAST(COUNT(c.id) AS INTEGER) as cantidad')
            )
            ->where('l.tipo','=','computo')
            ->where('l.id_institucion','=',session('id_institucion'))
            ->groupBy('l.id','l.nombre') 
            ->orderByDesc('cantidad')
            ->limit(10)
            ->get()
        ;

        return response()->json([
            'labels' => $datos->pluck('nombre'),
            'series' => $datos->pluck('cantidad'), 
            'color' => '#E53935',
            'graficos' => [
                'barras' => 'Cantidad de Computadoras Inactivas por Laboratorio'
            ]
        ]);
    }

    public function estadosComputadoras(Request $request)
    {
        $datos = 
            DB::table('computadoras as c')
            ->select(
                'c.estado',
                DB::raw('CAST(COUNT(*) AS INTEGER) as cantidad')
            )
            ->where('c.id_laboratorio','=',$request->id)
            ->groupBy('c.estado')
            ->get()
        ;

        return response()->json([
            'labels' => $datos->pluck('estado'),
            'series' => $datos->pluck('cantidad'), 
            'color' => '#7B1FA3',
            'graficos' => [
                'barras' => 'Cantidad de Computadoras Activas e Inactivas',
                'pastel' => 'Distribución de Computadoras Activas e Inactivas'
            ]
        ]);
    }

    public function distribucionMateriales(Request $request)
    {
        $datos = 
            DB::table('inventarios as i')
            ->join('materiales as m','m.id','=','i.id_material')
            ->select(
                'm.nombre',
                DB::raw('CAST(SUM(i.cantidad_total) AS INTEGER) as cantidad')
            )
            ->where('i.id_laboratorio','=',$request->id)
            ->groupBy('m.id','m.nombre')
            ->orderBy('cantidad','asc')
            ->get()
        ;

        return response()->json([
            'labels' => $datos->pluck('nombre'),
            'series' => $datos->pluck('cantidad'), 
            'color' => '#7B1FA3',
            'graficos' => [
                'barras' => 'Cantidad de Materiales en el Laboratorio'
            ]
        ]);
    }

    public function materialesConMasReportes(Request $request)
    {
        $datos = 
            DB::table('reportes_materiales as r')
            ->join('inventarios as i','i.id','=','r.id_inventario')
            ->join('materiales as m','m.id','=','i.id_material')
            ->select(
                'm.nombre',
                DB::raw('CAST(COUNT(r.id) AS INTEGER) as cantidad')
            )
            ->where('i.id_laboratorio','=',$request->id)
            ->groupBy('m.nombre') 
            ->orderBy('cantidad', 'desc')
            ->limit(10)
            ->get()
        ;

        return response()->json([
            'labels' => $datos->pluck('nombre'),
            'series' => $datos->pluck('cantidad'), 
            'color' => '#7B1FA3',
            'graficos' => [
                'barras' => 'Materiales con mas reportes de fallas',
            ]
        ]);
    }

    public function distribucionTiposUsuario(Request $request)
    {
        $datos = DB::table('usuarios as u')
            ->selectRaw("
                SUM(CASE WHEN normal = '1' THEN 1 ELSE 0 END) as Normal,
                SUM(CASE WHEN encargado = '1' THEN 1 ELSE 0 END) as Encargado,
                SUM(CASE WHEN mantenimiento = '1' THEN 1 ELSE 0 END) as Mantenimiento
            ")
            ->where('u.id_institucion','=',session('id_institucion'))
            ->first()
        ;

        $cantidad = 
            DB::table('usuarios as u')
            ->select('u.*')
            ->where('u.id_institucion','=',session('id_institucion'))
            ->get()
        ;

        return response()->json([
            'labels' => array_keys((array)$datos),
            'series' => array_values((array)$datos),
            'color' => '#7B1FA3',
            'total' => $cantidad->count(),
            'graficos' => [
                'barras' => 'Distribución de Usuarios por Rol',
                'pastel' => 'Distribución de Usuarios por Rol',
                'dona' => 'Distribución de Usuarios por Rol'    
            ]
        ]);
    }

    public function distribucionTiposLaboratorios(Request $request)
    {
        $datos = 
            DB::table('laboratorios as l')
            ->select(
                'l.tipo',
                DB::raw('CAST(COUNT(*) AS INTEGER) as cantidad')
            )
            ->where('l.id_institucion','=',session('id_institucion'))
            ->groupBy('l.tipo')
            ->get()
        ;

        return response()->json([
            'labels' => $datos->pluck('tipo'),
            'series' => $datos->pluck('cantidad'), 
            'color' => '#7B1FA3',
            'graficos' => [
                'barras' => 'Distribución de Laboratorios por Tipo',
                'pastel' => 'Distribución de Laboratorios por Tipo'
            ]
        ]);
    }

    public function cantidadEquiposComputo(Request $request){
        $menos = 
            DB::table('laboratorios as l')
            ->join('computadoras as c','c.id_laboratorio','=','l.id')
            ->select(
                'l.nombre',
                DB::raw('count(*) as cantidad')
            )
            ->where('l.id_institucion','=',session('id_institucion'))
            ->where('l.tipo','=','computo')
            ->where('c.estado','=','activo')
            ->groupBy('l.id')
            ->orderBy('cantidad','asc')
            ->limit(10)
            ->get()
        ;

        $mas = 
            DB::table('laboratorios as l')
            ->join('computadoras as c','c.id_laboratorio','=','l.id')
            ->select(
                'l.nombre',
                DB::raw('count(*) as cantidad')
            )
            ->where('l.id_institucion','=',session('id_institucion'))
            ->where('l.tipo','=','computo')
            ->where('c.estado','=','activo')
            ->groupBy('l.id')
            ->orderBy('cantidad','desc')
            ->limit(10)
            ->get()
        ;

        return response()->json([
            'dosGraficos' => true,
            'menos' => [
                'labels' => $menos->pluck('nombre'),
                'series' => $menos->pluck('cantidad'),
                'title' => 'Laboratorios con Menos Equipos de Cómputo',
                'color' => '#7B1FA3',
                'graficos' => [
                    'barras' => 'Laboratorios con Menos Equipos de Cómputo'
                ]
            ],
            'mas' => [
                'labels' => $mas->pluck('nombre'),
                'series' => $mas->pluck('cantidad'),
                'title' => 'Laboratorios con Más Equipos de Cómputo',
                'color' => '#7B1FA3',
                'graficos' => [
                    'barras' => 'Laboratorios con Más Equipos de Cómputo'
                ]
            ]
        ]);
    }

    public function laboratoriosPrestamosMasMenosSolicitudes(Request $request)
    {
        $menos = 
            DB::table('laboratorios as l')
            ->leftJoin('solicitudes as s', function($join) {
                $join->on(
                    DB::raw("CAST(s.info_usuario->>'idLaboratorio' AS INTEGER)"), 
                    '=', 
                    'l.id'
                );
            })
            ->select(
                'l.nombre',
                DB::raw('CAST(COUNT(s.id) AS INTEGER) as cantidad')
            )
            ->where('l.id_institucion','=',session('id_institucion'))
            ->where('l.tipo','=','prestamos')
            ->groupBy('l.id')
            ->orderBy('cantidad','asc')
            ->limit(10)
            ->get()
        ;

        $mas = 
            DB::table('laboratorios as l')
            ->leftJoin('solicitudes as s', function($join) {
                $join->on(
                    DB::raw("CAST(s.info_usuario->>'idLaboratorio' AS INTEGER)"), 
                    '=', 
                    'l.id'
                );
            })
            ->select(
                'l.nombre',
                DB::raw('count(s.id) as cantidad')
            )
            ->where('l.id_institucion','=',session('id_institucion'))
            ->where('l.tipo','=','prestamos')
            ->groupBy('l.id')
            ->orderBy('cantidad','DESC')
            ->limit(10)
            ->get()
        ;

        return response()->json([
            'dosGraficos' => true,
            'menos' => [
                'labels' => $menos->pluck('nombre'),
                'series' => $menos->pluck('cantidad'),
                'title' => 'Laboratorios con Menos Solicitudes de Préstamo',
                'color' => '#7B1FA3',
                'graficos' => [
                    'barras' => 'Laboratorios con Menos Solicitudes de Préstamo'
                ]
            ],
            'mas' => [
                'labels' => $mas->pluck('nombre'),
                'series' => $mas->pluck('cantidad'),
                'title' => 'Laboratorios con Más Solicitudes de Préstamo',
                'color' => '#7B1FA3',
                'graficos' => [
                    'barras' => 'Laboratorios con Más Solicitudes de Préstamo'
                ]
            ]
        ]);
    }

    public function laboratoriosComputoMasMenosSolicitudes(Request $request)
    {
        $menos = 
            DB::table('laboratorios as l')
            ->leftJoin('computadoras as c','c.id_laboratorio','=','l.id')
            ->leftJoin('solicitudes_computo as s','s.id_computadora','=','c.id')
            ->select(
                'l.nombre',
                DB::raw('COUNT(s.id) as cantidad')
            )
            ->where('l.id_institucion','=',session('id_institucion'))
            ->where('l.tipo','=','computo')
            ->groupBy('l.id','l.nombre')
            ->orderBy('cantidad','asc')
            ->limit(10)
            ->get()
        ;

        $mas = 
            DB::table('laboratorios as l')
            ->leftJoin('computadoras as c','c.id_laboratorio','=','l.id')
            ->leftJoin('solicitudes_computo as s','s.id_computadora','=','c.id')
            ->select(
                'l.nombre',
                DB::raw('COUNT(s.id) as cantidad')
            )
            ->where('l.id_institucion','=',session('id_institucion'))
            ->where('l.tipo','=','computo')
            ->groupBy('l.id','l.nombre')
            ->orderBy('cantidad','desc')
            ->limit(10)
            ->get()
        ;

        return response()->json([
            'dosGraficos' => true,
            'menos' => [
                'labels' => $menos->pluck('nombre'),
                'series' => $menos->pluck('cantidad'),
                'title' => 'Laboratorios con Menos Reportes de Computo',
                'color' => '#7B1FA3',
                'graficos' => [
                    'barras' => 'Laboratorios con Menos Reportes de Computo'
                ]
            ],
            'mas' => [
                'labels' => $mas->pluck('nombre'),
                'series' => $mas->pluck('cantidad'),
                'title' => 'Laboratorios con Más Reportes de Computo',
                'color' => '#7B1FA3',
                'graficos' => [
                    'barras' => 'Laboratorios con Más Reportes de Computo'
                ]
            ]
        ]);
    }

    public function materialesMasMenosSolicitados(Request $request)
    {
        $menos = 
            DB::table('solicitudes as s')
            ->join('laboratorios as l', function($join) {
                $join->on(
                    DB::raw("CAST(s.info_usuario->>'idLaboratorio' AS INTEGER)"), 
                    '=', 
                    'l.id'
                );
            })
            ->crossJoin(DB::raw("jsonb_array_elements(s.info_material) as m"))
            ->select(
                DB::raw("m->>'nombre' as nombre"),
                DB::raw("CAST(SUM(CAST(m->>'cantidad' AS INTEGER)) AS INTEGER) as cantidad")
            )
            ->where('l.id_institucion', '=', session('id_institucion'))
            ->where('l.tipo', '=', 'prestamos')
            ->groupBy(DB::raw("m->>'nombre'"))
            ->orderBy('cantidad', 'asc')
            ->limit(10)
            ->get()
        ;

        $mas = 
            DB::table('solicitudes as s')
            ->join('laboratorios as l', function($join) {
                $join->on(
                    DB::raw("CAST(s.info_usuario->>'idLaboratorio' AS INTEGER)"), 
                    '=', 
                    'l.id'
                );
            })
            ->crossJoin(DB::raw("jsonb_array_elements(s.info_material) as m"))
            ->select(
                DB::raw("m->>'nombre' as nombre"),
                DB::raw("CAST(SUM(CAST(m->>'cantidad' AS INTEGER)) AS INTEGER) as cantidad")
            )
            ->where('l.id_institucion', '=', session('id_institucion'))
            ->where('l.tipo', '=', 'prestamos')
            ->groupBy(DB::raw("m->>'nombre'"))
            ->orderBy('cantidad', 'desc')
            ->limit(10)
            ->get()
        ;

        return response()->json([
            'dosGraficos' => true,
            'menos' => [
                'labels' => $menos->pluck('nombre'),
                'series' => $menos->pluck('cantidad'),
                'title' => 'Laboratorios con Menos Reportes de Computo',
                'color' => '#7B1FA3',
                'graficos' => [
                    'barras' => 'Laboratorios con Menos Reportes de Computo'
                ]
            ],
            'mas' => [
                'labels' => $mas->pluck('nombre'),
                'series' => $mas->pluck('cantidad'),
                'title' => 'Laboratorios con Más Reportes de Computo',
                'color' => '#7B1FA3',
                'graficos' => [
                    'barras' => 'Laboratorios con Más Reportes de Computo'
                ]
            ]
        ]);
    }

    public function materialesMasMenosSolicitadosLaboratorio(Request $request)
    {
        $menos = DB::table('solicitudes as s')
        ->crossJoin(DB::raw("jsonb_array_elements(s.info_material) as m"))
        ->select(
            DB::raw("m->>'nombre' as nombre"),
            DB::raw("CAST(SUM(CAST(m->>'cantidad' AS INTEGER)) AS INTEGER) as cantidad")
        )
        ->where(DB::raw("CAST(s.info_usuario->>'idLaboratorio' AS INTEGER)"), '=', $request->id)
        ->groupBy(DB::raw("m->>'nombre'"))
        ->orderBy('cantidad', 'asc')
        ->limit(10)
        ->get();

        $mas = DB::table('solicitudes as s')
        ->crossJoin(DB::raw("jsonb_array_elements(s.info_material) as m"))
        ->select(
            DB::raw("m->>'nombre' as nombre"),
            DB::raw("CAST(SUM(CAST(m->>'cantidad' AS INTEGER)) AS INTEGER) as cantidad")
        )
        ->where(DB::raw("CAST(s.info_usuario->>'idLaboratorio' AS INTEGER)"), '=', $request->id)
        ->groupBy(DB::raw("m->>'nombre'"))
        ->orderBy('cantidad', 'desc')
        ->limit(10)
        ->get();

        return response()->json([
            'dosGraficos' => true,
            'menos' => [
                'labels' => $menos->pluck('nombre'),
                'series' => $menos->pluck('cantidad'),
                'title' => 'Materiales con Menos Solicitudes en el Laboratorio',
                'color' => '#7B1FA3',
                'graficos' => [
                    'barras' => 'Materiales con Menos Solicitudes en el Laboratorio'
                ]
            ],
            'mas' => [
                'labels' => $mas->pluck('nombre'),
                'series' => $mas->pluck('cantidad'),
                'title' => 'Materiales con Más Solicitudes en el Laboratorio',
                'color' => '#7B1FA3',
                'graficos' => [
                    'barras' => 'Materiales con Más Solicitudes en el Laboratorio'
                ]
            ]
        ]);
    }


    public function computadorasMasFallas(Request $request)
    {
        $datos = 
            DB::table('computadoras as c')
            ->join('solicitudes_computo as s','s.id_computadora','=','c.id')
            ->select(
                'c.numero_computadora as nombre',
                DB::raw('count(s.id) as cantidad')
            )
            ->where('c.id_laboratorio','=',$request->id)
            ->groupBy('c.id','c.numero_computadora')
            ->orderBy('cantidad','desc')
            ->limit(10)
            ->get()
        ;

        return response()->json([
            'labels' => $datos->pluck('nombre'),
            'series' => $datos->pluck('cantidad'), 
            'color' => '#7B1FA3',
            'graficos' => [
                'barras' => 'Computadoras con Más Fallas Reportadas',
                'pastel' => 'Distribución de Fallas por Computadora'
            ]
        ]);
    }
}
