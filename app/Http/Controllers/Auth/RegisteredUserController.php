<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'dni' => ['required', 'string', 'max:20', 'unique:'.User::class],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        'birth_date' => ['required', 'date', 'before:today'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'address' => ['nullable', 'string', 'max:255'],
        'phone' => ['nullable', 'string', 'max:20'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'dni' => $request->dni,
        'email' => $request->email,
        'birth_date' => $request->birth_date,
        'address' => $request->address,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
    ]);

    // Asignar rol "fan" por defecto
    $fanRole = Role::where('name', 'fan')->first();
    if ($fanRole) {
        $user->roles()->attach($fanRole->id);
    }

    Auth::login($user);

    return redirect(RouteServiceProvider::HOME);
}
}
