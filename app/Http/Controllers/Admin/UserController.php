<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
}