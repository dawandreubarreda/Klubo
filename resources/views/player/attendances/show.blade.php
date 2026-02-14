@extends('layouts.app')

@section('title', 'Asistencias - ' . $team->name)

@section('content')
    <h1>Asistencias: {{ $team->name }}</h1>

    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('player.dashboard') }}" class="btn" style="background: #64748b; color: white; display: inline-block; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">
            ← Volver a mis equipos
        </a>
    </div>

    <!-- Estadísticas de asistencia -->
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
        <h3>📊 Estadísticas de asistencia</h3>
        <p><strong>Asistencias:</strong> {{ $attendedSessions }} de {{ $totalSessions }} sesiones</p>
        <p><strong>Porcentaje:</strong> <span style="font-size: 1.2em; font-weight: bold; color: #059669;">{{ $attendancePercentage }}%</span></p>
        
        @if($attendancePercentage >= 90)
            <p style="color: #059669;">🌟 ¡Excelente asistencia!</p>
        @elseif($attendancePercentage >= 70)
            <p style="color: #ca8a04;">👍 Buena asistencia</p>
        @elseif($attendancePercentage >= 50)
            <p style="color: #dc2626;">⚠️ Asistencia regular</p>
        @else
            <p style="color: #dc2626;">❌ Baja asistencia</p>
        @endif
    </div>

    @if($trainings->isEmpty())
        <p>No hay sesiones de entrenamiento registradas.</p>
    @else
        <h3>Historial detallado</h3>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                <thead>
                    <tr style="background: #f1f5f9;">
                        <th style="padding: 0.75rem; text-align: left; border: 1px solid #e2e8f0;">Fecha</th>
                        <th style="padding: 0.75rem; text-align: left; border: 1px solid #e2e8f0;">Descripción</th>
                        <th style="padding: 0.75rem; text-align: center; border: 1px solid #e2e8f0;">Asistencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trainings as $training)
                        @php
                            $attendance = $training->attendances->firstWhere('user_id', auth()->id());
                            $attended = $attendance ? $attendance->attended : false;
                        @endphp
                        <tr>
                            <td style="padding: 0.75rem; border: 1px solid #e2e8f0;">
                                {{ \Carbon\Carbon::parse($training->training_date)->format('d/m/Y') }}
                            </td>
                            <td style="padding: 0.75rem; border: 1px solid #e2e8f0;">
                                {{ $training->description ?? 'Sesión de entrenamiento' }}
                            </td>
                            <td style="padding: 0.75rem; text-align: center; border: 1px solid #e2e8f0;">
                                @if($attended)
                                    ✅
                                @else
                                    ❌
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div style="margin-top: 2rem;">
        <a href="{{ route('player.dashboard') }}" class="btn" style="background: #64748b; color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 4px;">
            ← Volver a mis equipos
        </a>
    </div>
@endsection