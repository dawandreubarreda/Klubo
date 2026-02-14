<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Team;
use App\Models\Training;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Team $team)
    {
        $user = Auth::user();
        
        // Verificar que hay usuario autenticado y es entrenador del equipo
        if (!$user || !$team->users()->where('user_id', $user->id)->wherePivot('role_in_team', 'coach')->exists()) {
            abort(403);
        }

        // Cargar sesiones de entrenamiento con asistencias
        $trainings = $team->trainings()
            ->with('players')
            ->orderBy('training_date', 'desc')
            ->get();

        // Jugadores del equipo
        $players = $team->users()->wherePivot('role_in_team', 'player')->get();

        return view('coach.attendances.index', compact('team', 'trainings', 'players'));
    }

    // Método para crear una nueva sesión de entrenamiento y generar registros de asistencia.
    public function store(Request $request, Team $team)
    {
        $user = Auth::user();
        if (!$user || !$team->users()->where('user_id', $user->id)->wherePivot('role_in_team', 'coach')->exists()) {
            abort(403);
        }

        $request->validate([
            'training_date' => 'required|date',
            'description' => 'nullable|string|max:255'
        ]);

        // Crear la sesión de entrenamiento
        $training = $team->trainings()->create([
            'training_date' => $request->training_date,
            'description' => $request->description
        ]);

        // Crear registros de asistencia pendientes para todos los jugadores del equipo
        $players = $team->users()->wherePivot('role_in_team', 'player')->get();
        foreach ($players as $player) {
            $training->attendances()->create([
                'user_id' => $player->id,
                'attended' => false // Inicialmente marcado como no asistió (puedes cambiar a null si prefieres)
            ]);
        }

        return back()->with('success', 'Sesión de entrenamiento creada correctamente.');
    }

    // Método para actualizar las asistencias de una sesión de entrenamiento.
    public function update(Request $request, Team $team)
    {
        $user = Auth::user();
        if (!$user || !$team->users()->where('user_id', $user->id)->wherePivot('role_in_team', 'coach')->exists()) {
            abort(403);
        }

        // Validar que los datos recibidos son correctos
        $request->validate([
            'attendances' => 'required|array',
            'attendances.*' => 'boolean'
        ]);

        // Actualizar las asistencias
        foreach ($request->attendances as $attendanceId => $attended) {
            $attendance = Attendance::find($attendanceId);
            if ($attendance && $attendance->training->team_id === $team->id) {
                $attendance->update(['attended' => (bool) $attended]);
            }
        }

        return back()->with('success', 'Asistencias actualizadas correctamente.');
    }

    // Método para eliminar una sesión de entrenamiento y sus registros de asistencia.
    public function destroy(Team $team, Training $training)
    {
        $user = Auth::user();
        if (!$user || !$team->users()->where('user_id', $user->id)->wherePivot('role_in_team', 'coach')->exists()) {
            abort(403);
        }

        // Verificar que la sesión pertenece al equipo
        if ($training->team_id !== $team->id) {
            abort(403);
        }

        $training->delete();

        return back()->with('success', 'Sesión de entrenamiento eliminada correctamente.');
    }
}
