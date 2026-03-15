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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string("Nombre_Usuario")->unique();
            $table->string("Email");
            $table->string("Contrasena");
            $table->string("Nombre");
            $table->string("Admin")->nullable();
            $table->string("Mantenimiento");
            $table->string("Encargado");
            $table->string("Normal");
            $table->unsignedBigInteger("ID_Grupo")->nullable();
            $table->unsignedBigInteger("ID_Institucion");
            $table->timestamps();

            $table->foreign("ID_Grupo")->references("id")->on("grupos")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("ID_Institucion")->references("id")->on("instituciones")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
