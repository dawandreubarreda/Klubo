<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/// Modelo de categoría para representar las categorías de edad en el sistema.

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'min_age', 'max_age'];

    // Relación uno a muchos con equipos
    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}