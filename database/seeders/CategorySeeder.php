<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    
    // Ejecutar el seeder para poblar la tabla categories con datos iniciales.
    public function run(): void
    {
        $categories = [
            ['name' => 'Prebenjamín', 'min_age' => 6, 'max_age' => 7],
            ['name' => 'Benjamín', 'min_age' => 8, 'max_age' => 9],
            ['name' => 'Alevín', 'min_age' => 10, 'max_age' => 11],
            ['name' => 'Infantil', 'min_age' => 12, 'max_age' => 13],
            ['name' => 'Cadete', 'min_age' => 14, 'max_age' => 15],
            ['name' => 'Junior', 'min_age' => 16, 'max_age' => 17],
            ['name' => 'Senior', 'min_age' => 18, 'max_age' => 99],
        ];

        foreach ($categories as $category) {
            // Solo crea la categoría si no existe.
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}