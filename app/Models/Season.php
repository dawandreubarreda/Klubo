<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Modelo para representar las temporadas de la liga. Cada temporada tiene un nombre, fecha de inicio y fecha de fin.
class Season extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_date', 'end_date'];
}