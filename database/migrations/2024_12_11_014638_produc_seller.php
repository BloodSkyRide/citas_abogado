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
        Schema::create('productos_venta', function (Blueprint $table) {

            $table->id("id_producto");
            $table->string("nombre_producto",255);
            $table->bigInteger("precio")->nullable();
            $table->string("categoria",100)->nullable();
            $table->text("descripcion")->nullable();
            $table->date('fecha_creacion')->nullable();
            $table->string('tipo_producto', 100)->nullable();
            $table->text('url_imagen')->nullabler();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_venta');
    }
};
