@extends('layouts.app')

@section('title', 'Roles - Klubo')

@section('content')
    <h1>Roles disponibles en Klubo</h1>

    @if($roles->isEmpty())
        <p>No hay roles registrados.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre técnico</th>
                    <th>Nombre visible</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->display_name }}</td>
                    <td>{{ $role->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="/" class="btn">← Volver al inicio</a>
@endsection