<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'TurnosOnline')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-gray-900 min-h-screen flex flex-col">

    {{-- HEADER --}}
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            {{-- LOGO --}}
            <a href="/" class="text-xl font-bold text-indigo-600">
                TurnosOnline
            </a>

            {{-- LINKS --}}
            <div class="space-x-4">
                @auth
                    <a href="{{ route('turnos.index') }}" class="text-gray-700 hover:text-indigo-600">
                        Mis turnos
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600">
                        Iniciar sesión
                    </a>

                    <a href="{{ route('register') }}"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                        Registrarse
                    </a>
                @endauth
            </div>

        </div>
    </header>

    {{-- CONTENIDO --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-white border-t mt-10">
        <div class="max-w-7xl mx-auto px-6 py-6 text-center text-sm text-gray-500">
            © {{ date('Y') }} TurnosOnline — Reservá fácil.
        </div>
    </footer>

</body>

</html>
