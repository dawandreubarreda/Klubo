<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Modelo para registrar los entrenamientos del equipo.
class Training extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'training_date', 'description'];

    // Relaciones
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'attendances')
            ->withPivot('attended')
            ->withTimestamps();
    }
}