@extends('layouts.app')

@section('title', 'Gestión de Usuarios - Klubo')

@section('content')
    <h1>Gestión de Usuarios</h1>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles as $role)
                        <span style="background: #dbeafe; padding: 0.25rem 0.5rem; border-radius: 4px; margin-right: 0.25rem;">
                            {{ $role->display_name }}
                        </span>
                    @endforeach
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        
                        @foreach($roles as $role)
                            <label style="display: block; margin: 0.25rem 0;">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" 
                                    @if($user->roles->contains($role->id)) checked @endif>
                                {{ $role->display_name }}
                            </label>
                        @endforeach
                        
                        <button type="submit" class="btn" style="margin-top: 0.5rem;">Actualizar Roles</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection