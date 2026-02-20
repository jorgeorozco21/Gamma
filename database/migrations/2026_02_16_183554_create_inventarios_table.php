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
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("ID_Material");
            $table->integer("Cantidad_Disponible");
            $table->integer("Cantidad_Total");
            $table->unsignedBigInteger("ID_Laboratorio");
            $table->timestamps();

            $table->foreign("ID_Material")->references("id")->on("materiales")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("ID_Laboratorio")->references("id")->on("laboratorios")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
