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
            $table->unsignedBigInteger("ID_Solicitud");
            $table->string("Estado");
            $table->unsignedBigInteger("ID_Usuario");
            $table->string("Fecha");
            $table->timestamps();

            $table->foreign("ID_Solicitud")->references("id")->on("solicitudes")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("ID_Usuario")->references("id")->on("usuarios")->onUpdate("cascade");
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
