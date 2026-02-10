<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear la tabla de equipos con sus relaciones a temporadas y categorías.
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Nombre del equipo
            $table->foreignId('season_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->enum('gender', ['masculino', 'femenino', 'mixto']);
            $table->timestamps();
        });
    }

    /**
     * Eliminar la tabla de equipos si se revierte la migración.
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
};
