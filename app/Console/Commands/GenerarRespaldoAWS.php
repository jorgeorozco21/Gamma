<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class GenerarRespaldoAWS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup-aws';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un volcado de la base de datos MySQL y lo sube directamente a Amazon S3';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando el respaldo de la base de datos...');

        Log::info('Comando db:backup-aws: Iniciando respaldo.');

        try{

            // Guardado localmente
            Artisan::call('backup:run', [
                '--only-db' => true,
                '--only-to-disk' => 'local' 
            ]);

            // Guardado en AWS S3
            /*
            Artisan::call('backup:run', [
                '--only-db' => true,
                '--only-to-disk' => 's3' 
            ]);
            */

            $output = Artisan::output();

            $this->info('Respaldo completado con éxito.');

            Log::info('Comando db:backup-aws: Respaldo exitoso. Detalle: ' . $output);

        }catch (\Exception $e){
            $this->error('Error al generar el respaldo: ' . $e->getMessage());

            Log::error('Comando db:backup-aws: Falló el respaldo. Error: ' . $e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
