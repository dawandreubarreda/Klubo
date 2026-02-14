@extends('layouts.app')

@section('title', 'Asistencias - ' . $team->name)

@section('content')
    <h1>Asistencias: {{ $team->name }}</h1>

    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('coach.dashboard') }}" class="btn" style="background: #64748b; color: white; display: inline-block; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">
            ← Volver al dashboard
        </a>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario para crear nueva sesión -->
    <div style="margin-bottom: 2rem; padding: 1rem; background: #f8fafc; border-radius: 8px;">
        <h3>Nueva sesión de entrenamiento</h3>
        <form method="POST" action="{{ route('coach.attendances.store', $team) }}">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 1rem; align-items: end;">
                <div>
                    <label for="training_date">Fecha:</label>
                    <input type="date" name="training_date" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div>
                    <label for="description">Descripción (opcional):</label>
                    <input type="text" name="description" placeholder="Entrenamiento técnico, partido, etc." style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <button type="submit" class="btn" style="background: #059669; color: white; padding: 0.5rem 1rem; border-radius: 4px;">
                    Crear sesión
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de asistencias -->
    @if($trainings->isEmpty())
        <p>No hay sesiones de entrenamiento creadas.</p>
    @else
        <h3>Historial de asistencias</h3>
        
        <form method="POST" action="{{ route('coach.attendances.update', $team) }}">
            @csrf
            @method('PUT')
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                    <thead>
                        <tr style="background: #f1f5f9;">
                            <th style="padding: 0.75rem; text-align: left; border: 1px solid #e2e8f0;">Jugador</th>
                            @foreach($trainings as $training)
                                <th style="padding: 0.75rem; text-align: center; border: 1px solid #e2e8f0; min-width: 100px;">
                                    {{ \Carbon\Carbon::parse($training->training_date)->format('d/m') }}
                                    @if($training->description)
                                        <br><small>{{ $training->description }}</small>
                                    @endif
                                    <br>
                                    <button type="submit" formaction="{{ route('coach.attendances.destroy', [$team, $training]) }}" 
                                            formmethod="POST" 
                                            onclick="return confirm('¿Eliminar esta sesión?')"
                                            style="color: #ef4444; font-size: 0.8rem; background: none; border: none; cursor: pointer;">
                                        🗑️
                                    </button>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($players as $player)
                            <tr>
                                <td style="padding: 0.75rem; border: 1px solid #e2e8f0;">{{ $player->name }}</td>
                                @foreach($trainings as $training)
                                    @php
                                        $attendance = $training->attendances->firstWhere('user_id', $player->id);
                                    @endphp
                                    <td style="padding: 0.75rem; text-align: center; border: 1px solid #e2e8f0;">
                                        @if($attendance)
                                            <input type="hidden" name="attendances[{{ $attendance->id }}]" value="0">
                                            <input type="checkbox" 
                                                name="attendances[{{ $attendance->id }}]" 
                                                value="1"
                                                @if($attendance->attended) checked @endif
                                                style="width: 20px; height: 20px;">
                                        @else
                                            ⏳
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div style="margin-top: 1rem;">
                <button type="submit" class="btn" style="background: #7c3aed; color: white; padding: 0.5rem 1rem; border-radius: 4px;">
                    Guardar asistencias
                </button>
            </div>
        </form>
    @endif
@endsection