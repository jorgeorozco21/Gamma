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
        Schema::create('auditoria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_solicitud");
            $table->string("estado");
            $table->unsignedBigInteger("id_usuario");
            $table->string("fecha");
            $table->timestamps();

            $table->foreign("id_solicitud")->references("id")->on("solicitudes")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("id_usuario")->references("id")->on("usuarios")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditoria');
    }
};
