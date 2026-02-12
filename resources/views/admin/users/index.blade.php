<td>
    <!-- Botón Editar -->
    <a href="{{ route('admin.users.edit', $user) }}" class="btn" style="display: inline-block; margin-bottom: 0.5rem;">Editar</a>
    
    <!-- Formulario para actualizar roles -->
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