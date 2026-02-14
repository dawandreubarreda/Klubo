<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Modelo para registrar la asistencia de los jugadores a los entrenamientos.
class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['training_id', 'user_id', 'attended'];

    // Relaciones
    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}