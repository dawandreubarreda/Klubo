<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ====== MÉTODOS EXISTENTES (gestión de roles) ======
    
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin.roles.index', compact('users', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        // Sincronizar roles (asigna solo los seleccionados)
        $user->roles()->sync($request->roles ?? []);

        return redirect()->back()->with('success', 'Roles actualizados correctamente.');
    }

    // ====== MÉTODOS (gestión de perfiles) ======

    /**
     * Mostrar lista de todos los usuarios para edición de perfiles
     */
    public function profilesIndex()
    {
        $users = User::with('roles')->orderBy('name')->get();
        return view('admin.profiles.index', compact('users'));
    }

    /**
     * Mostrar formulario para editar perfil de un usuario específico
     */
    public function profilesEdit(User $user)
    {
        return view('admin.profiles.edit', compact('user'));
    }

    /**
     * Actualizar perfil de un usuario específico
     */
    public function profilesUpdate(Request $request, User $user)
    {
        // Validar los datos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:masculino,femenino,otro'
        ]);

        // Verificar si el usuario está asignado a equipos como jugador
        $isPlayerInTeams = $user->teams()->wherePivot('role_in_team', 'player')->exists();

        if ($isPlayerInTeams) {
            // Si está en equipos como jugador, verificar cambios críticos
            
            // Verificar cambio de fecha de nacimiento
            if ($user->birth_date != $request->birth_date) {
                return back()->withErrors(['birth_date' => 'No se puede modificar la fecha de nacimiento porque el usuario está asignado a equipos como jugador.']);
            }

            // Verificar cambio de género en equipos no mixtos
            $teams = $user->teams()->wherePivot('role_in_team', 'player')->get();
            foreach ($teams as $team) {
                if ($team->gender !== 'mixto' && $user->gender != $request->gender) {
                    return back()->withErrors(['gender' => 'No se puede modificar el género porque el usuario pertenece a equipos que requieren el género actual.']);
                }
            }
        }

        // Actualizar los datos
        $user->update($validated);

        return redirect()->route('admin.profiles.index')->with('success', 'Perfil actualizado correctamente.');
    }
}