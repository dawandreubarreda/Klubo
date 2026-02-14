<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\Attendance;
use App\Models\Training;

class PlayerController extends Controller
{
    // Mostrar el dashboard del jugador con los equipos en los que participa
    public function dashboard()
    {
        $user = Auth::user();
        // Obtener equipos donde el usuario es JUGADOR (no entrenador)
        $teams = $user->teams()->wherePivot('role_in_team', 'player')->with('season', 'category')->get();
        
        return view('player.dashboard', compact('teams'));
    }

    // Mostrar asistencias del jugador para un equipo específico.
    public function showAttendances(Team $team)
    {
        $user = Auth::user();
        
        // Verificar que el usuario es jugador del equipo (especificar tabla para evitar ambigüedad)
        if (!$team->users()->where('users.id', $user->id)->wherePivot('role_in_team', 'player')->exists()) {
            abort(403);
        }

        // Obtener todas las sesiones del equipo
        $trainings = $team->trainings()->orderBy('training_date', 'desc')->get();
        
        // Calcular porcentaje de asistencia
        $totalSessions = $trainings->count();
        $attendedSessions = 0;
        
        if ($totalSessions > 0) {
            $attendedSessions = Attendance::where('user_id', $user->id)
                ->whereIn('training_id', $trainings->pluck('id'))
                ->where('attended', true)
                ->count();
            
            $attendancePercentage = round(($attendedSessions / $totalSessions) * 100, 1);
        } else {
            $attendancePercentage = 0;
        }

        return view('player.attendances.show', compact('team', 'trainings', 'attendancePercentage', 'totalSessions', 'attendedSessions'));
    }
}