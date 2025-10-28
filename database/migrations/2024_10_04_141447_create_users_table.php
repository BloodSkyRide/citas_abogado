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
        Schema::create('users', function (Blueprint $table) {
            
            $table->id();
            $table->string('cedula',255)->unique();
            $table->text('password');
            $table->string('nombre',255)->nullable();
            $table->string('apellido',255)->nullable();
            $table->date('fecha_registro')->nullable();
            $table->date('fecha_notificacion')->nullable();
            $table->string('rol',255);
            $table->string('direccion',255)->nullable();
            $table->text('email')->nullable();
            $table->String('telefono',255)->nullable();
            $table->String('contacto_emergencia',255)->nullable();
            $table->String('nombre_contacto',255)->nullable();
            $table->text('permisos')->nullable();
            $table->text('url',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
