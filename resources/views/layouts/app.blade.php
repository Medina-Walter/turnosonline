<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Turnos Online')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-indigo-600 text-white shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between">
        <span class="font-bold">Turnos Online</span>
        <span class="text-sm">Panel</span>
    </div>
</nav>

<main class="max-w-4xl mx-auto mt-8 px-4">

    @if(session('success'))
        <div class="mb-4 rounded bg-green-100 text-green-800 p-3">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 rounded bg-red-100 text-red-800 p-3">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

</body>
</html>
