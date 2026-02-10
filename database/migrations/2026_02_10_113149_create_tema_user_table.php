<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear la tabla pivot para la relación muchos a muchos entre equipos y usuarios, incluyendo el rol del usuario en el equipo.
     * El campo 'role_in_team' permite diferenciar entre jugadores y entrenadores dentro de un mismo equipo.
     */
    public function up()
    {
        Schema::create('team_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role_in_team', ['player', 'coach']);
            $table->timestamps();
        });
    }

    /**
     * Eliminar la tabla pivot si se revierte la migración.
     */
    public function down()
    {
        Schema::dropIfExists('team_user');
    }
};
