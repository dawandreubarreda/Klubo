@extends('layouts.app')

@section('title', 'Editar perfil - ' . $user->name)

@section('content')
    <h1>✏️ Editar perfil: {{ $user->name }}</h1>

    @if($errors->any())
        <div style="background: #fee; color: #b91c1c; padding: 1rem; border-radius: 4px; margin-bottom: 1rem;">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('admin.profiles.index') }}" class="btn" style="background: #64748b; color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 4px;">
            ← Volver a perfiles
        </a>
    </div>

    <form method="POST" action="{{ route('admin.profiles.update', $user) }}">
        @csrf
        @method('PUT')

        <div style="display: grid; gap: 1rem; margin-bottom: 1.5rem;">
            <!-- Nombre -->
            <div>
                <label for="name" style="display: block; margin-bottom: 0.25rem; font-weight: bold;">Nombre completo</label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $user->name) }}" 
                       required 
                       style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <!-- Email -->
            <div>
                <label for="email" style="display: block; margin-bottom: 0.25rem; font-weight: bold;">Email</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       value="{{ old('email', $user->email) }}" 
                       required 
                       style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <!-- Teléfono -->
            <div>
                <label for="phone" style="display: block; margin-bottom: 0.25rem; font-weight: bold;">Teléfono (opcional)</label>
                <input type="text" 
                       name="phone" 
                       id="phone" 
                       value="{{ old('phone', $user->phone) }}" 
                       style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <!-- Dirección -->
            <div>
                <label for="address" style="display: block; margin-bottom: 0.25rem; font-weight: bold;">Dirección (opcional)</label>
                <input type="text" 
                       name="address" 
                       id="address" 
                       value="{{ old('address', $user->address) }}" 
                       style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <!-- Fecha de nacimiento -->
            <div>
                <label for="birth_date" style="display: block; margin-bottom: 0.25rem; font-weight: bold;">Fecha de nacimiento</label>
                <input type="date" 
                       name="birth_date" 
                       id="birth_date" 
                       value="{{ old('birth_date', $user->birth_date) }}" 
                       required 
                       style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <!-- Género -->
            <div>
                <label style="display: block; margin-bottom: 0.25rem; font-weight: bold;">Género</label>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="radio" 
                               name="gender" 
                               value="masculino" 
                               @if(old('gender', $user->gender) == 'masculino') checked @endif
                               required>
                        Masculino ♂️
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="radio" 
                               name="gender" 
                               value="femenino" 
                               @if(old('gender', $user->gender) == 'femenino') checked @endif
                               required>
                        Femenino ♀️
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem;">
                        <input type="radio" 
                               name="gender" 
                               value="otro" 
                               @if(old('gender', $user->gender) == 'otro') checked @endif
                               required>
                        Otro ⚧️
                    </label>
                </div>
            </div>
        </div>

        <button type="submit" 
                class="btn" 
                style="background: #dc2626; color: white; padding: 0.75rem 1.5rem; border-radius: 6px; font-weight: bold;">
            Actualizar perfil
        </button>
    </form>
@endsection
