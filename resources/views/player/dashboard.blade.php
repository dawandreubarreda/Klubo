@extends('layouts.app')

@section('title', 'Mi Panel - Jugador')

@section('content')
    <h1>Mis Equipos</h1>
    
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($teams->isEmpty())
        <p>No estás asignado a ningún equipo como jugador.</p>
    @else
        <div style="display: grid; gap: 1rem; margin-bottom: 2rem;">
            @foreach($teams as $team)
                <div style="border: 1px solid #e5e7eb; padding: 1rem; border-radius: 8px;">
                    <h3>{{ $team->name }}</h3>
                    <p><strong>Temporada:</strong> {{ $team->season->name }}</p>
                    <p><strong>Categoría:</strong> {{ $team->category->name }}</p>
                    <p><strong>Género:</strong> {{ ucfirst($team->gender) }}</p>
                    <a href="{{ route('player.attendances.show', $team) }}" class="btn" style="background: #059669; color: white;">
                        Ver asistencias
                    </a>
                </div>
            @endforeach
        </div>
    @endif
    
    <div style="margin-top: 2rem;">
        <a href="{{ route('dashboard') }}" class="btn" style="background: #64748b; color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 4px;">
            ← Volver al dashboard principal
        </a>
    </div>
@endsection