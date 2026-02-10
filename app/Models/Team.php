<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'season_id', 'category_id', 'gender'];

    // Relaciones
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user')
            ->withPivot('role_in_team')
            ->withTimestamps();
    }
}