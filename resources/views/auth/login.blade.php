@extends('layouts.app')

@section('title', 'Iniciar sesión - Klubo')

@section('content')
    <div class="auth-container">
        <h1>Iniciar sesión</h1>

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

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div style="margin-bottom: 1rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Contraseña</label>
                <input type="password" id="password" name="password" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <input type="checkbox" id="remember_me" name="remember">
                <label for="remember_me" style="display: inline; margin-left: 0.5rem;">Recordarme</label>
            </div>

            <button type="submit" class="btn" style="width: 100%;">Iniciar sesión</button>
        </form>

        <div style="margin-top: 1.5rem; text-align: center;">
            <p>¿No tienes cuenta? <a href="{{ route('register') }}" style="color: #3b82f6; text-decoration: none;">Regístrate aquí</a></p>
        </div>
    </div>
@endsection