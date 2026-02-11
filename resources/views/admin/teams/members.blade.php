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

    <!-- Añadir nuevos miembros -->
    <h2>Añadir nuevos miembros</h2>
    <!-- Mostrar errores de validación -->
    @if($errors->any())
        <div style="background: #fee; color: #b91c1c; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            <strong>Error al añadir miembro:</strong>
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif  
    <form method="POST" action="{{ route('admin.teams.add-member', $team) }}">
        @csrf
        <div style="margin-bottom: 1rem;">
            <label for="user_id">Usuario</label>
            <select name="user_id" required style="width: 100%; padding: 0.5rem;">
                <option value="">Selecciona un usuario</option>
                @foreach($availableUsers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>
        <div style="margin-bottom: 1rem;">
            <label for="role_in_team">Rol en el equipo</label>
            <select name="role_in_team" required style="width: 100%; padding: 0.5rem;">
                <option value="player">Jugador</option>
                <option value="coach">Entrenador</option>
            </select>
        </div>
        <button type="submit" class="btn">Añadir al equipo</button>
    </form>
@endsection