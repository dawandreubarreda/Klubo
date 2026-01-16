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
        Schema::table('users', function (Blueprint $table) {
            //Añadir columna dni a la tabla users
            $table->string('dni')->unique()->after('id');
            //Añadir columnas fecha nacimiento, dirección y teléfono en la tabla users
            $table->date('birth_date')->nullable()->after('email');
            $table->text('address')->nullable()->after('birth_date');
            $table->string('phone')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //Eliminar columna dni de la tabla users
            $table->dropColumn('dni');
            //Eliminar columnas fecha nacimiento, dirección y teléfono a la tabla users
            $table->dropColumn(['dni', 'birth_date', 'address', 'phone']);
        });
    }
};
