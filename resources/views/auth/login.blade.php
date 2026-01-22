<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | TurnosOnline</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl px-10 py-12">

        <h1 class="text-3xl font-bold text-center text-gray-800">
            Bienvenido
        </h1>
        <p class="text-center text-gray-500 mt-2 mb-8">
            Inicia sesión en tu cuenta
        </p>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                >
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Contraseña
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                >
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Button -->
            <button
                type="submit"
                class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-3 rounded-lg font-semibold transition"
            >
                Iniciar sesión
            </button>

            <!-- Divider -->
            <div class="flex items-center gap-4 my-4">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-sm text-gray-400">o continúa con</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <!-- Google -->
            <button type="button"
                class="w-full flex items-center justify-center gap-3 border border-gray-300 rounded-lg py-3 hover:bg-gray-50 transition">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
                <span class="font-medium text-gray-700">Continuar con Google</span>
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-8">
            ¿No tenés cuenta?
            <a href="{{ route('register') }}" class="text-indigo-500 font-medium hover:underline">
                Registrarse
            </a>
        </p>

    </div>

</body>
</html>
