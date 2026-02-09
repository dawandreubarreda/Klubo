<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración para crear la tabla 'seasons' con los campos necesarios.
     * La tabla almacenará las temporadas de la liga, con su nombre, fecha de inicio y fecha de fin.
     */
    public function up()
{
    Schema::create('seasons', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique(); // Ej: "2025-2026"
        $table->date('start_date');      // 2025-09-01
        $table->date('end_date');        // 2026-06-30
        $table->timestamps();
    });
}
    /**
     * Eliminar la tabla 'seasons' si es necesario.
     */
    public function down()
{
    Schema::dropIfExists('seasons');
}
};
