@extends('layouts.app')

@section('title', 'Equipos de ' . $season->name . ' - Klubo')

@section('content')
    <h1>Equipos de {{ $season->name }}</h1>

    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.teams.create') }}" class="btn" style="background: #1e40af; color: white;">
            + Crear Nuevo Equipo
        </a>
        <a href="{{ route('admin.seasons.index') }}" style="margin-left: 1rem;">Volver a temporadas</a>
    </div>

    @if($teams->isEmpty())
        <p>No hay equipos en esta temporada.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Género</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $team)
                <tr>
                    <td>{{ $team->name }}</td>
                    <td>{{ $team->category->name }}</td>
                    <td>{{ ucfirst($team->gender) }}</td>
                    <td>
                        <a href="{{ route('admin.teams.edit', $team) }}">Editar</a> |
                        <a href="{{ route('admin.teams.members', $team) }}">Miembros</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection