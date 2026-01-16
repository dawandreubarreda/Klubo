<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Klubo')</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
<body>
    <header>
        <div class="logo">Klubo</div>
        <nav>
            <a href="/">Inicio</a>
            <a href="/roles">Roles</a>
            <a href="/login">Iniciar sesión</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>Proyecto Klubo • Desarrollado por estudiantes de DAW •
           <a href="https://github.com/dawandreubarreda/Klubo" target="_blank">GitHub</a>
        </p>
    </footer>
</body>
</html>