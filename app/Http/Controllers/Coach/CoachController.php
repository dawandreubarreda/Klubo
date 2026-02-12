<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    // Mostrar el panel de entrenador con sus equipos.
    public function dashboard()
    {
        $user = auth()->user();
        $teams = $user->teams()->wherePivot('role_in_team', 'coach')->with('season', 'category')->get();

        return view('coach.dashboard', compact('teams'));
    }

    // Mostrar detalles de un equipo específico para el entrenador
    public function showTeam(Team $team)
    {
        // Verificar que el usuario es entrenador de este equipo
        if (!$team->users()->where('user_id', auth()->id())->wherePivot('role_in_team', 'coach')->exists()) {
            abort(403);
        }

        $players = $team->users()->wherePivot('role_in_team', 'player')->get();

        // Obtener jugadores elegibles
        $availablePlayers = \App\Models\User::whereDoesntHave('teams', function($query) use ($team) {
            $query->where('team_id', $team->id);
        })->get()->filter(function($user) use ($team) {
            return app(\App\Http\Controllers\Admin\TeamController::class)->validatePlayerEligibility($team, $user);
        });

        return view('coach.teams.show', compact('team', 'players', 'availablePlayers'));
    }
    //Añadir un jugador a un equipo desde el panel del entrenador.
    public function addPlayer(Request $request, Team $team)
    {
        // Validar que el usuario es entrenador del equipo
        if (!$team->users()->where('user_id', auth()->id())->wherePivot('role_in_team', 'coach')->exists()) {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);

        // Verificar que no esté ya en el equipo
        if ($team->users()->where('user_id', $user->id)->exists()) {
            return back()->withErrors(['user_id' => 'Este jugador ya está en el equipo.']);
        }

        // Validar que es elegible
        if (!app(\App\Http\Controllers\Admin\TeamController::class)->validatePlayerEligibility($team, $user)) {
            return back()->withErrors(['user_id' => 'Este jugador no cumple los requisitos para este equipo.']);
        }

        // Añadir como jugador
        $team->users()->attach($user->id, ['role_in_team' => 'player']);

        return back()->with('success', 'Jugador añadido correctamente.');
    }
}
