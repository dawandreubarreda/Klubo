@extends('layouts.app')

@section('title', 'Miembros de ' . $team->name . ' - Klubo')

@section('content')
    <h1>Miembros de {{ $team->name }}</h1>

    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.teams.index') }}">Volver a equipos</a>
    </div>

    <!-- Miembros actuales -->
    <h2>Miembros actuales</h2>
    @if($currentMembers->isEmpty())
        <p>No hay miembros en este equipo.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol en equipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($currentMembers as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ ucfirst($member->pivot->role_in_team) }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.teams.remove-member', $team) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="user_id" value="{{ $member->id }}">
                            <button type="submit" style="color: #dc2626; text-decoration: underline;">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Añadir jugadores -->
<h2>Añadir jugadores</h2>
@if($errors->has('player_user_id'))
    <div style="background: #fee; color: #b91c1c; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
        {{ $errors->first('player_user_id') }}
    </div>
@endif
<form method="POST" action="{{ route('admin.teams.add-member', $team) }}">
    @csrf
    <input type="hidden" name="role_in_team" value="player">
    <div style="margin-bottom: 1rem;">
        <label for="player_user_id">Jugador</label>
        <select name="user_id" id="player_user_id" style="width: 100%; padding: 0.5rem;">
            <option value="">Selecciona un jugador elegible</option>
            @foreach($eligiblePlayers as $player)
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

    <!-- Añadir entrenadores -->
    <h2 style="margin-top: 2rem;">Añadir entrenadores</h2>
    @if($errors->has('coach_user_id'))
        <div style="background: #fee; color: #b91c1c; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            {{ $errors->first('coach_user_id') }}
        </div>
    @endif
    <form method="POST" action="{{ route('admin.teams.add-member', $team) }}" style="margin-top: 1rem;">
        @csrf
        <input type="hidden" name="role_in_team" value="coach">
        <div style="margin-bottom: 1rem;">
            <label for="coach_user_id">Entrenador</label>
            <select name="user_id" id="coach_user_id" style="width: 100%; padding: 0.5rem;">
                <option value="">Selecciona un entrenador elegible</option>
                @foreach($eligibleCoaches as $coach)
                    <option value="{{ $coach->id }}">
                        {{ $coach->name }} ({{ $coach->email }})
                        @if($coach->gender === 'masculino') ♂️
                        @elseif($coach->gender === 'femenino') ♀️
                        @else ⚧️
                        @endif
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn" style="background: #7c3aed; color: white;">Añadir Entrenador</button>
    </form>
@endsection
