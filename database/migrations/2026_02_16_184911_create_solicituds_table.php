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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_usuario");
            $table->unsignedBigInteger("id_inventario")->nullable();
            $table->integer("cantidad")->nullable();
            $table->text("descripcion")->nullable();
            $table->string("fecha");
            $table->timestamps();

            $table->foreign("id_usuario")->references("id")->on("usuarios")->onUpdate("cascade");
            $table->foreign("id_inventario")->references("id")->on("inventarios")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes');
    }
};
