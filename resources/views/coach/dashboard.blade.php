@extends('layouts.app')

@section('title', 'Mi Panel - Entrenador')

@section('content')
    <h1>Mis Equipos</h1>

    @if($teams->isEmpty())
        <p>No estás asignado a ningún equipo como entrenador.</p>
    @else
        <div style="display: grid; gap: 1rem; margin-bottom: 2rem;">
            @foreach($teams as $team)
                <div style="border: 1px solid #e5e7eb; padding: 1rem; border-radius: 8px;">
                    <h3>{{ $team->name }}</h3>
                    <p><strong>Temporada:</strong> {{ $team->season->name }}</p>
                    <p><strong>Categoría:</strong> {{ $team->category->name }}</p>
                    <p><strong>Género:</strong> {{ ucfirst($team->gender) }}</p>
                    <a href="{{ route('coach.teams.show', $team) }}" class="btn" style="background: #1e40af; color: white;">
                        Gestionar equipo
                    </a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
