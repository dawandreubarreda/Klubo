@extends('layouts.app')

@section('title', 'Editar Equipo - Klubo')

@section('content')
    <h1>Editar Equipo: {{ $team->name }}</h1>

    <form method="POST" action="{{ route('admin.teams.update', $team) }}">
        @csrf
        @method('PUT')
        @if($redirectBack)
            <input type="hidden" name="redirect_back" value="{{ $redirectBack }}">
        @endif

        <div style="margin-bottom: 1rem;">
            <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nombre del equipo</label>
            <input type="text" id="name" name="name" required value="{{ old('name', $team->name) }}" 
                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="season_id" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Temporada</label>
            <select id="season_id" name="season_id" required 
                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
                <option value="">Selecciona una temporada</option>
                @foreach($seasons as $season)
                    <option value="{{ $season->id }}" {{ old('season_id', $team->season_id) == $season->id ? 'selected' : '' }}>
                        {{ $season->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="category_id" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Categoría</label>
            <select id="category_id" name="category_id" required 
                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
                <option value="">Selecciona una categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $team->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }} ({{ $category->min_age }}-{{ $category->max_age }} años)
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="gender" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Género</label>
            <select id="gender" name="gender" required 
                style="width: 100%; padding: 0.75rem; border: 1px solid #ccc; border-radius: 4px;">
                <option value="">Selecciona...</option>
                <option value="masculino" {{ old('gender', $team->gender) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="femenino" {{ old('gender', $team->gender) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                <option value="mixto" {{ old('gender', $team->gender) == 'mixto' ? 'selected' : '' }}>Mixto</option>
            </select>
        </div>

        <button type="submit" class="btn" style="background: #1e40af; color: white;">Actualizar Equipo</button>
        <a href="{{ route('admin.teams.index') }}" style="margin-left: 1rem;">Cancelar</a>
    </form>
@endsection