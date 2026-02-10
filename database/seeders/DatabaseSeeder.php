<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Este método se ejecuta cuando haces: php artisan db:seed
     * Aquí llamamos a otros seeders específicos para cada tabla.
     */
    public function run(): void
    {
        // Llamamos a los seeders de roles y categorías
        // Estos seeders insertan los datos básicos que necesita la aplicación
        $this->call([
            \Database\Seeders\RoleSeeder::class,      // Seeder para roles (admin, coach, etc.)
            \Database\Seeders\CategorySeeder::class, // Seeder para categorías deportivas
        ]);
    }
}