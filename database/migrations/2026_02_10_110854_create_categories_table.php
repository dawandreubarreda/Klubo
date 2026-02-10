<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear la migración de la tabla categories.
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('min_age');
            $table->integer('max_age');
            $table->timestamps();
        });
}

    /**
     * Eliminar la migración de la tabla categories.
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
