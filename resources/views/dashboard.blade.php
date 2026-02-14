@use('Illuminate\Support\Str')
@extends('layouts.app')

@section('title', 'Dashboard - Klubo')

@section('content')
    <h1>Panel de Control</h1>

    @if(auth()->user()->hasRole('admin'))
        <div class="admin-section">
            <h2>👨‍💼 Área del Administrador</h2>
            <ul>
                <li><a href="{{ route('admin.roles') }}">Gestión de roles</a></li>
                <li><a href="{{ route('admin.profiles.index') }}">Gestión de perfiles</a></li>
                <li><a href="{{ route('admin.seasons.index') }}">Gestionar temporadas</a></li>
                <li><a href="{{ route('admin.teams.index') }}">Gestionar equipos</a></li>
            </ul>
        </div>
    @endif

    @if(auth()->user()->hasRole('coach'))
        <div class="coach-section">
            <h2>🏃 Área del Entrenador</h2>
            <a href="{{ route('coach.dashboard') }}">Ir a mi panel de entrenador</a>
        </div>
    @endif

    @if(auth()->user()->hasRole('player'))
        <div class="player-section">
            <h2>🏃 Área del Jugador</h2>
            <a href="{{ route('player.dashboard') }}">Ir a mi panel de jugador</a>
        </div>
    @endif
    
    <!-- Enlace para editar perfil propio -->
    <div class="section">
        <h2>👤 Mi perfil</h2>
        <p>Gestiona tus datos personales y preferencias.</p>
        <a href="{{ route('profile.edit') }}" class="btn" style="background: #059669; color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 4px; display: inline-block;">
            Editar mi perfil
        </a>
    </div>

    @if(auth()->user()->hasRole('fan'))
        <!-- Tablón de anuncios en el dashboard -->
        <div class="section">
            <h2>📰 Últimas noticias del club</h2>
            <div style="max-height: 400px; overflow-y: auto;">
                @php
                    $dashboardNews = \App\Models\NewsPost::with('user')->latest()->take(5)->get();
                @endphp
                
                @if($dashboardNews->isEmpty())
                    <p>No hay noticias publicadas.</p>
                @else
                    @foreach($dashboardNews as $post)
                        <div style="border: 1px solid #e5e7eb; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                            <p style="margin: 0;">{{ Str::limit($post->content, 150) }}</p>
                            <div style="color: #64748b; font-size: 0.85rem; margin-top: 0.5rem;">
                                <strong>{{ $post->user->name }}</strong> • {{ $post->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div style="margin-top: 1rem;">
                <a href="{{ route('news.index') }}" class="btn" style="background: #7c3aed; color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 4px;">
                    Ver todas las noticias
                </a>
            </div>
        </div>
    @endif
@endsection
