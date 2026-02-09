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
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[a-zA-ZÀ-ÿ\s]+$/'
            ],
            'dni' => [
                'required',
                'string',
                'max:20',
                'unique:users',
                'regex:/^([0-9]{8}[A-Z]|[XYZ][0-9]{7}[A-Z])$/i'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],
            'birth_date' => [
                'required',
                'date',
                'before:today',
                'after:1920-01-01'
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => [
                'nullable',
                'regex:/^[0-9]{9}$/'
            ],
        ], [
            'dni.regex' => 'El DNI debe tener 8 dígitos y una letra (ej. 12345678Z) o formato NIE (X1234567L).',
            'phone.regex' => 'El teléfono debe tener exactamente 9 dígitos.',
            'birth_date.after' => 'La fecha de nacimiento debe ser posterior al 1 de enero de 1920.',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
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
