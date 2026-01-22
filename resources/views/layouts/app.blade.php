<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Turnos Online')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen">

    <nav class="bg-indigo-600 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">

            <span class="font-bold text-lg">
                Turnos Online
            </span>

            <div class="flex items-center gap-6">
                <a href="{{ route('cliente.index') }}"
                    class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-semibold hover:bg-indigo-100 transition">
                    Mis Turnos
                </a>

                <a href="{{ route('negocios.index') }}" class="px-4 py-2 hover:underline font-semibold text-white">
                    Mis Negocios
                </a>

                {{-- Logout --}}
                @auth
                    <details class="relative">
                        <summary class="flex items-center gap-2 cursor-pointer focus:outline-none list-none select-none">
                            <!-- Icono usuario -->
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="8" r="4" />
                                <path d="M16 20H8a2 2 0 0 1-2-2v-2a4 4 0 0 1 8 0v2a2 2 0 0 1-2 2z" />
                            </svg>
                            <span class="font-semibold text-white">{{ Auth::user()->nombre }}</span>
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </summary>
                        <div class="absolute right-0 mt-2 w-48 bg-white text-gray-600 rounded-lg shadow-lg z-30">
                            <a href="{{ route('perfil.index') }}"
                                class="block px-4 py-3 hover:bg-indigo-50 font-medium rounded-t-lg">
                                Mi perfil
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-3 hover:bg-indigo-50 font-medium rounded-b-lg">
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </details>
                @endauth
            </div>
        </div>
    </nav>


    <main class="max-w-4xl mx-auto mt-8 px-4">

        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 text-green-800 p-3">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 text-red-800 p-3">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

</body>

</html>
