<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migración para agregar el campo de género a la tabla de usuarios
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('gender', ['masculino', 'femenino', 'otro'])->default('otro')->after('birth_date');
        });
    }

    /**
     * Migración para eliminar el campo de género de la tabla de usuarios
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }
};
