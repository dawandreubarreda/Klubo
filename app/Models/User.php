<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'dni',
        'email',
        'birth_date',
        'gender',
        'address',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // Relación muchos a muchos con roles
    public function roles()
        {
            return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
        }
    
    // Método para verificar si el usuario tiene un rol específico
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    // Relación muchos a muchos con equipos, incluyendo el rol del usuario en cada equipo
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user')
            ->withPivot('role_in_team')
            ->withTimestamps();
    }

    // Relación uno a muchos con asistencias.
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
