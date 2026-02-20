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
            $table->unsignedBigInteger("ID_Usuario");
            $table->unsignedBigInteger("ID_Inventario")->nullable();
            $table->integer("Cantidad")->nullable();
            $table->text("Descripcion")->nullable();
            $table->string("Fecha");
            $table->timestamps();

            $table->foreign("ID_Usuario")->references("id")->on("usuarios")->onUpdate("cascade");
            $table->foreign("ID_Inventario")->references("id")->on("inventarios")->onDelete("cascade")->onUpdate("cascade");
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
