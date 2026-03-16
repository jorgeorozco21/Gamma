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
            $table->unsignedBigInteger("id_material");
            $table->integer("cantidad_disponible");
            $table->integer("cantidad_total");
            $table->unsignedBigInteger("id_laboratorio");
            $table->timestamps();

            $table->foreign("id_material")->references("id")->on("materiales")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("id_laboratorio")->references("id")->on("laboratorios")->onDelete("cascade")->onUpdate("cascade");
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
