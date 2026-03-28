<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitudes_eliminadas', function (Blueprint $table) {
            $table->id();
            $table->string("id_solicitud");
            $table->unsignedBigInteger("id_usuario");
            $table->unsignedBigInteger("id_laboratorio");
            $table->string("fecha");
            $table->timestamps();

            $table->foreign("id_usuario")->references("id")->on("usuarios")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("id_laboratorio")->references("id")->on("laboratorios")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_eliminadas');
    }
};
