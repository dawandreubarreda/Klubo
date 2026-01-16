<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //Creación de los 4 tipos diferentes de roles que puede tener un user (Admin, coach, player y fan)
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrador',
                'description' => 'Gestión de todo el sistema'
            ],
            [
                'name' => 'coach',
                'display_name' => 'Entrenador',
                'description' => 'Gestión de equipos y asistencias'
            ],
            [
                'name' => 'player',
                'display_name' => 'Jugador',
                'description' => 'Participa en entrenamientos y Partidos'
            ],
            [
                'name' => 'fan',
                'display_name' => 'Socio/Aficionado',
                'description' => 'Visualiza información del club'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
