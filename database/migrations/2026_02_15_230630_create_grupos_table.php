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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string("Nombre");
            $table->string("Grado");
            $table->string("Grupo");
            $table->text("Laboratorios");
            $table->unsignedBigInteger("ID_Institucion");
            $table->timestamps();

            $table->foreign("ID_Institucion")->references("id")->on("instituciones")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
