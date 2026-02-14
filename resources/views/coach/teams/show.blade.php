@extends('layouts.app')

@section('title', 'Gestionar ' . $team->name)

@section('content')
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <h1>Gestionar {{ $team->name }}</h1>
    
    <!--Botón para volver al dashboard del coach-->
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('coach.dashboard') }}" class="btn" style="background: #64748b; color: white; display: inline-block; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">
            ← Volver al dashboard
        </a>
    </div>
    <div style="margin-bottom: 2rem;">
        <strong>Temporada:</strong> {{ $team->season->name }}<br>
        <strong>Categoría:</strong> {{ $team->category->name }}<br>
        <strong>Género:</strong> {{ ucfirst($team->gender) }}
    </div>

    <!-- Jugadores actuales -->
    <h2>Jugadores del equipo</h2>
    @if($players->isEmpty())
        <p>No hay jugadores en este equipo.</p>
    @else
        <ul>
            @foreach($players as $player)
                <li>{{ $player->name }} ({{ $player->email }})</li>
            @endforeach
        </ul>
    @endif

    <!-- Acciones del equipo -->
<div style="margin-top: 2rem;">
    <h3>Acciones</h3>
    <a href="{{ route('coach.teams.add-player', $team) }}" class="btn" style="background: #059669; color: white; display: inline-block; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; margin-right: 1rem;">
        ➕ Añadir jugador
    </a>
    <a href="{{ route('coach.attendances.index', $team) }}" class="btn" style="background: #7c3aed; color: white; display: inline-block; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">
        📊 Gestionar asistencias
    </a>
</div>

    @if($availablePlayers->isEmpty())
        <p>No hay jugadores elegibles disponibles.</p>
    @else
        <form method="POST" action="{{ route('coach.teams.add-player', $team) }}">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label for="user_id">Selecciona un jugador:</label>
                <select name="user_id" id="user_id" required style="width: 100%; padding: 0.5rem;">
                    <option value="">-- Elige un jugador --</option>
                    @foreach($availablePlayers as $player)
                        <option value="{{ $player->id }}">
                            {{ $player->name }} ({{ $player->email }})
                            @if($player->gender === 'masculino') ♂️
                            @elseif($player->gender === 'femenino') ♀️
                            @else ⚧️
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn" style="background: #059669; color: white;">Añadir Jugador</button>
        </form>
    @endif
    
@endsection
