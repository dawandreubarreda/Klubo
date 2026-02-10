@extends('layouts.app')

@section('title', 'Dashboard - Klubo')

@section('content')
    <h1>Panel de Control</h1>

    @if(auth()->user()->hasRole('admin'))
        <div class="admin-section">
            <h2>👨‍💼 Área del Administrador</h2>
            <ul>
                <li><a href="{{ route('admin.roles') }}">Gestión de roles</a></li>
                <li><a href="/admin/profiles">Gestión de perfiles</a></li>
                <li><a href="{{ route('admin.seasons.index') }}">Gestionar temporadas</a></li>
                <li><a href="{{ route('admin.teams.index') }}">Gestionar equipos</a></li>
                <li><a href="/admin/news">Gestionar tablón de anuncios</a></li>
            </ul>
        </div>
    @endif

    @if(auth()->user()->hasRole('coach'))
        <div class="coach-section">
            <h2>🏃 Área del Entrenador</h2>
            <p>Gestiona tus jugadores y entrenamientos.</p>
        </div>
    @endif

    @if(auth()->user()->hasRole('player'))
        <div class="player-section">
            <h2>🎾 Área del Jugador</h2>
            <p>Consulta tus partidos y estadísticas.</p>
        </div>
    @endif

    @if(auth()->user()->hasRole('fan'))
        <div class="fan-section">
            <h2>📣 Tablón de Anuncios</h2>
            <p>Próximamente: noticias, eventos y novedades del club.</p>
        </div>
    @endif
@endsection