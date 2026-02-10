@extends('layouts.app')

@section('title', 'Equipos - Klubo')

@section('content')
    <h1>Equipos</h1>
    
    <div style="margin-bottom: 1.5rem;">
        <a href="#" class="btn" style="background: #1e40af; color: white;">
            + Crear Nuevo Equipo
        </a>
    </div>

    @if($teams->isEmpty())
        <p>No hay equipos creados.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Temporada</th>
                    <th>Categoría</th>
                    <th>Género</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $team)
                <tr>
                    <td>{{ $team->name }}</td>
                    <td>{{ $team->season->name }}</td>
                    <td>{{ $team->category->name }}</td>
                    <td>{{ ucfirst($team->gender) }}</td>
                    <td>
                        <a href="#">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection