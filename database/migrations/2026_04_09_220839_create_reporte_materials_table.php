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
        Schema::create('reportes_materiales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_inventario");
            $table->jsonb('info_usuario');
            $table->integer("cantidad");
            $table->text("descripcion");
            $table->unsignedBigInteger('id_institucion');
            $table->timestamps();

            $table->foreign('id_inventario')->references('id')->on('inventarios')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reporte_materials');
    }
};
