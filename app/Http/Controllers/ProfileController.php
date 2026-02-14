<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Team;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Verificar si el usuario está asignado a equipos como jugador
        $isPlayerInTeams = $user->teams()->wherePivot('role_in_team', 'player')->exists();

        if ($isPlayerInTeams) {
            // Si está en equipos como jugador, verificar cambios críticos
            
            // Verificar cambio de fecha de nacimiento
            if ($user->birth_date != $request->birth_date) {
                return back()->withErrors(['birth_date' => 'No se puede modificar la fecha de nacimiento porque estás asignado a equipos como jugador.']);
            }

            // Verificar cambio de género en equipos no mixtos
            $teams = $user->teams()->wherePivot('role_in_team', 'player')->get();
            foreach ($teams as $team) {
                if ($team->gender !== 'mixto' && $user->gender != $request->gender) {
                    return back()->withErrors(['gender' => 'No se puede modificar el género porque perteneces a equipos que requieren tu género actual.']);
                }
            }
        }

        // Actualizar los datos del usuario
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}