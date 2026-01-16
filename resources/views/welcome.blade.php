@extends('layouts.app')

@section('title', 'Klubo - Gestión Deportiva')

@section('content')
    <h1>Gestión Deportiva para Clubes Locales</h1>
    <p>
        Bienvenido a <strong>Klubo</strong>, el sistema integral para la gestión de clubes deportivos.
        Nuestra plataforma permite administrar usuarios, roles, equipos, categorías y asistencia a entrenamientos
        de forma segura y eficiente.
    </p>

    <div class="features">
        <h2>Estado actual del proyecto</h2>
        <ul>
            <li>✅ Sistema de roles múltiples implementado (admin, entrenador, jugador, socio)</li>
            <li>✅ Base de datos relacional funcional</li>
            <li>✅ Interfaz básica de visualización de roles</li>
            <li>🔜 Próximamente: registro de usuarios, autenticación, gestión de equipos</li>
        </ul>
        <a href="/roles" class="btn">Ver roles disponibles</a>
    </div>
@endsection