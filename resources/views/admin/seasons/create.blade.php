@extends('layouts.app')

@section('title', 'Crear Temporada - Klubo')

@section('content')
    <h1>Crear Nueva Temporada</h1>

    <div style="background: #fee; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
        <p><strong>⚠️ Importante:</strong> Las temporadas son permanentes y no se pueden modificar ni eliminar.</p>
        <p>Para continuar, escribe <strong>"confirmar"</strong> en el campo de abajo.</p>
    </div>

    <form method="POST" action="{{ route('admin.seasons.store') }}">
        @csrf

        <div style="margin-bottom: 1rem;">
            <label for="name">Nombre (ej. 2025-2026)</label>
            <input type="text" id="name" name="name" required value="{{ old('name') }}" style="width: 100%; padding: 0.5rem;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="start_date">Fecha inicio</label>
            <input type="date" id="start_date" name="start_date" required value="{{ old('start_date') }}" style="width: 100%; padding: 0.5rem;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="end_date">Fecha fin</label>
            <input type="date" id="end_date" name="end_date" required value="{{ old('end_date') }}" style="width: 100%; padding: 0.5rem;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="confirmation">Confirmación</label>
            <input type="text" id="confirmation" name="confirmation" required placeholder="Escribe 'confirmar'" style="width: 100%; padding: 0.5rem;">
        </div>

        <button type="submit" class="btn">Crear Temporada</button>
        <a href="{{ route('admin.seasons.index') }}" style="margin-left: 1rem;">Cancelar</a>
    </form>
@endsection