<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Migración para crear la tabla 'attendances' con los campos necesarios
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('attended')->default(false);
            $table->timestamps();
            
            // Evitar duplicados
            $table->unique(['training_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};