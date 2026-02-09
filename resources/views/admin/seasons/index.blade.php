@extends('layouts.app')

@section('title', 'Temporadas - Klubo')

@section('content')
    <h1>Temporadas</h1>
    
    @if($currentSeason)
        <div style="background: #dbeafe; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            <strong>📅 Temporada actual:</strong> {{ $currentSeason->name }}
            <a href="#" style="margin-left: 1rem;">Ver equipos</a>
        </div>
    @endif

    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.seasons.create') }}" class="btn" style="background: #1e40af; color: white;">
            + Crear Nueva Temporada
        </a>
    </div>

    @if($seasons->isEmpty())
        <p>No hay temporadas creadas.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($seasons as $season)
                <tr>
                    <td>
                        @if($currentSeason && $currentSeason->id === $season->id)
                            <strong>{{ $season->name }} (Actual)</strong>
                        @else
                            {{ $season->name }}
                        @endif
                    </td>
                    <td>{{ $season->start_date }}</td>
                    <td>{{ $season->end_date }}</td>
                    <td>
                        <a href="#">Ver equipos</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection