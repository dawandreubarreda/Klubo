@extends('layouts.app')

@section('title', 'Registro - Klubo')

@section('content')
    <div class="auth-container">
        <h1>Crear cuenta</h1>

        <!-- Mensajes de error -->
        @if ($errors->any())
            <div style="background: #fee; color: #c00; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div style="margin-bottom: 1rem;">
                <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nombre completo</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="dni" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">DNI</label>
                <input type="text" id="dni" name="dni" value="{{ old('dni') }}" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="birth_date" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Fecha de nacimiento</label>
                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <!-- Opcional: dirección y teléfono -->
            <div style="margin-bottom: 1rem;">
                <label for="address" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Dirección</label>
                <input type="text" id="address" name="address" value="{{ old('address') }}"
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Teléfono</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Contraseña</label>
                <input type="password" id="password" name="password" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Confirmar contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <button type="submit" class="btn" style="width: 100%;">Crear cuenta</button>
        </form>

        <div style="margin-top: 1.5rem; text-align: center;">
            <p>¿Ya tienes cuenta? <a href="{{ route('login') }}" style="color: #3b82f6; text-decoration: none;">Inicia sesión</a></p>
        </div>
    </div>
@endsection