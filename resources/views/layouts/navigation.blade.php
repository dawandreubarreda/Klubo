<header>
    <div class="logo">Klubo</div>
    <nav>
        <a href="/">Inicio</a>
        <a href="/roles">Roles</a>
        @guest
            <a href="/login">Iniciar sesión</a>
        @else
            <span>Bienvenido, {{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: white; text-decoration: underline; cursor: pointer;">Cerrar sesión</button>
            </form>
        @endguest
    </nav>
</header>