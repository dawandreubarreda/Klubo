@extends('layouts.app')

@section('title', 'Gestión de perfiles - Klubo')

@section('content')
    <h1>👥 Gestión de perfiles</h1>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.roles') }}" class="btn" style="background: #64748b; color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 4px;">
            ← Volver a gestión de roles
        </a>
    </div>

    @if($users->isEmpty())
        <p>No hay usuarios registrados.</p>
    @else
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
                <thead>
                    <tr style="background: #f1f5f9;">
                        <th style="padding: 0.75rem; text-align: left; border: 1px solid #e2e8f0;">Nombre</th>
                        <th style="padding: 0.75rem; text-align: left; border: 1px solid #e2e8f0;">Email</th>
                        <th style="padding: 0.75rem; text-align: left; border: 1px solid #e2e8f0;">Teléfono</th>
                        <th style="padding: 0.75rem; text-align: left; border: 1px solid #e2e8f0;">Roles</th>
                        <th style="padding: 0.75rem; text-align: center; border: 1px solid #e2e8f0;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td style="padding: 0.75rem; border: 1px solid #e2e8f0;">{{ $user->name }}</td>
                            <td style="padding: 0.75rem; border: 1px solid #e2e8f0;">{{ $user->email }}</td>
                            <td style="padding: 0.75rem; border: 1px solid #e2e8f0;">{{ $user->phone ?? '-' }}</td>
                            <td style="padding: 0.75rem; border: 1px solid #e2e8f0;">
                                @foreach($user->roles as $role)
                                    <span style="background: #e0f2fe; color: #0369a1; padding: 0.25rem 0.5rem; border-radius: 4px; margin-right: 0.25rem;">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td style="padding: 0.75rem; text-align: center; border: 1px solid #e2e8f0;">
                                <a href="{{ route('admin.profiles.edit', $user) }}" 
                                   class="btn" 
                                   style="background: #059669; color: white; text-decoration: none; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.85rem;">
                                    Editar perfil
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection