<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LimpiarBaseDatos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clear-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpia la base de datos eliminando registros antiguos o innecesarios.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fechaLimiteUsuario = Carbon::now()->subMonths(40)->startOfDay();
        $fechaLimiteSolicitudes = Carbon::now()->subYear()->startOfDay();

        $this->info("Iniciando proceso de limpieza de registros antiguos...");
        Log::info("Comando db:clear-old: Buscando registros creados antes de: " . $fechaLimiteSolicitudes->toDateTimeString() . " para solicitudes y reportes, y antes de: " . $fechaLimiteUsuario->toDateTimeString() . " para usuarios.");

        try{
            // ==========================================
            // PROCESO 1: TABLA solicitudes_computo
            // ==========================================

            $idSolicitudesComputoAEliminar = 
                DB::table('solicitudes_computo as s')
                ->leftJoin('auditoria_computo as a', function($join) {
                    $join->on('s.id', '=', 'a.id_solicitud')
                        ->whereRaw('a.id = (SELECT MAX(id) FROM auditoria_computo WHERE id_solicitud = s.id)');
                })
                ->where('a.estado', '=', 'completado')
                ->where('s.created_at', '<', $fechaLimiteSolicitudes)
                ->pluck('s.id')
            ;

            if ($idSolicitudesComputoAEliminar->isNotEmpty()){
                $cantidadSolicitudesComputoAEliminar = $idSolicitudesComputoAEliminar->count();

                DB::table('solicitudes_computo')
                ->whereIn('id', $idSolicitudesComputoAEliminar)
                ->delete();
                
                $this->info("Se eliminaron {$cantidadSolicitudesComputoAEliminar} registros antiguos en la tabla 'solicitudes_computo'.");
                Log::info("Comando db:clear-old: Se eliminaron {$cantidadSolicitudesComputoAEliminar} registros en la tabla 'solicitudes_computo'.");
            }else{
                $this->info("No se encontraron registros antiguos para eliminar.");
                Log::info("Comando db:clear-old: No se encontraron registros antiguos para eliminar.");
            }

            $this->info("Ejecutando VACUUM en la tabla 'solicitudes_computo'...");

            DB::statement("VACUUM ANALYZE solicitudes_computo");

            $this->info("Tabla 'solicitudes_computo' optimizada con VACUUM ANALYZE con éxito.");
            Log::info("Comando db:clear-old: VACUUM ANALYZE ejecutado correctamente.");

            // ==========================================
            // PROCESO 2: TABLA solicitudes
            // ==========================================

            $idsSolicitudesAEliminar = 
                DB::table('solicitudes as s')
                ->leftJoin('auditoria as a', function($join) {
                    $join->on('s.id', '=', 'a.id_solicitud')
                        ->whereRaw('a.id = (SELECT MAX(id) FROM auditoria WHERE id_solicitud = s.id)');
                })
                ->where('a.estado','=','recibido')
                ->where('s.created_at', '<', $fechaLimiteSolicitudes)
                ->pluck('s.id')
            ;

            if ($idsSolicitudesAEliminar->isNotEmpty()){
                $cantidadSolicitudesAEliminar = $idsSolicitudesAEliminar->count();

                DB::table('solicitudes')
                ->whereIn('id', $idsSolicitudesAEliminar)
                ->delete();
                
                $this->info("Se eliminaron {$cantidadSolicitudesAEliminar} registros antiguos en la tabla 'solicitudes'.");
                Log::info("Comando db:clear-old: Se eliminaron {$cantidadSolicitudesAEliminar} registros en la tabla 'solicitudes'.");
            }else{
                $this->info("No se encontraron registros antiguos para eliminar en la tabla 'solicitudes'.");
                Log::info("Comando db:clear-old: No se encontraron registros antiguos para eliminar en la tabla 'solicitudes'.");
            }

            $this->info("Ejecutando VACUUM en la tabla 'solicitudes'...");
            DB::statement("VACUUM ANALYZE solicitudes");

            $this->info("Tabla 'solicitudes' optimizada con VACUUM ANALYZE con éxito.");
            Log::info("Comando db:clear-old: VACUUM ANALYZE ejecutado correctamente en la tabla 'solicitudes'.");
            
            // ==========================================
            // PROCESO 3: TABLA reportes
            // ==========================================

            $idsReportesAEliminar = 
                DB::table('reportes_materiales as r')
                ->leftJoin('auditoria_reportes_materiales as a', function($join) {
                    $join->on('r.id', '=', 'a.id_reporte')
                        ->whereRaw('a.id = (SELECT MAX(id) FROM auditoria_reportes_materiales WHERE id_reporte = r.id)');
                })
                ->whereIn('a.estado', ['recibido', 'sin reparacion'])
                ->where('r.created_at', '<', $fechaLimiteSolicitudes)
                ->pluck('r.id')
            ;

            if ($idsReportesAEliminar->isNotEmpty()){
                $cantidadReportesAEliminar = $idsReportesAEliminar->count();

                DB::table('reportes_materiales')
                ->whereIn('id', $idsReportesAEliminar)
                ->delete();
                
                $this->info("Se eliminaron {$cantidadReportesAEliminar} registros antiguos en la tabla 'reportes_materiales'.");
                Log::info("Comando db:clear-old: Se eliminaron {$cantidadReportesAEliminar} registros en la tabla 'reportes_materiales'.");
            }else{
                $this->info("No se encontraron registros antiguos para eliminar en la tabla 'reportes_materiales'.");
                Log::info("Comando db:clear-old: No se encontraron registros antiguos para eliminar en la tabla 'reportes_materiales'.");
            }

            $this->info("Ejecutando VACUUM en la tabla 'reportes_materiales'...");
            DB::statement("VACUUM ANALYZE reportes_materiales");

            $this->info("Tabla 'reportes_materiales' optimizada con VACUUM ANALYZE con éxito.");
            Log::info("Comando db:clear-old: VACUUM ANALYZE ejecutado correctamente en la tabla 'reportes_materiales'.");

            // ==========================================
            // PROCESO 4: TABLA usuarios
            // ==========================================

            $cantidadUsuariosAEliminar = 
                DB::table('usuarios')
                ->where('normal','=','1')
                ->where('created_at', '<', $fechaLimiteUsuario)
                ->count()
            ;

            if ($cantidadUsuariosAEliminar > 0){
                DB::table('usuarios')
                ->where('normal','=','1')
                ->where('created_at', '<', $fechaLimiteUsuario)
                ->delete();
                
                $this->info("Se eliminaron {$cantidadUsuariosAEliminar} registros antiguos en la tabla 'usuarios'.");
                Log::info("Comando db:clear-old: Se eliminaron {$cantidadUsuariosAEliminar} registros en la tabla 'usuarios'.");
            }else{
                $this->info("No se encontraron registros antiguos para eliminar en la tabla 'usuarios'.");
                Log::info("Comando db:clear-old: No se encontraron registros antiguos para eliminar en la tabla 'usuarios'.");
            }

            $this->info("Ejecutando VACUUM en la tabla 'usuarios'...");
            DB::statement("VACUUM ANALYZE usuarios");

            $this->info("Tabla 'usuarios' optimizada con VACUUM ANALYZE con éxito.");
            Log::info("Comando db:clear-old: VACUUM ANALYZE ejecutado correctamente en la tabla 'usuarios'.");

        }catch (\Exception $e){
            $this->error('Ocurrió un error durante el proceso: ' . $e->getMessage());
            Log::error('Comando db:clear-old: Error en la ejecución: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
