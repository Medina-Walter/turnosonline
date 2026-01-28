@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Volver --}}
        <a href="{{ route('negocios.index') }}"
            class="inline-block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
            Volver
        </a>

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ $negocio->nombre }}</h1>
            <p class="text-gray-600">Panel de administración del negocio</p>
        </div>

        {{-- Métricas --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white shadow rounded-xl p-5">
                <p class="text-gray-500 text-sm">Turnos hoy</p>
                <p class="text-3xl font-bold text-indigo-600">{{ $turnosHoy }}</p>
            </div>

            <div class="bg-white shadow rounded-xl p-5">
                <p class="text-gray-500 text-sm">Empleados</p>
                <p class="text-3xl font-bold text-gray-800">{{ $empleadosCount }}</p>
            </div>

            <div class="bg-white shadow rounded-xl p-5">
                <p class="text-gray-500 text-sm">Servicios activos</p>
                <p class="text-3xl font-bold text-gray-800">{{ $serviciosCount }}</p>
            </div>

        </div>

        {{-- Link público --}}
        <div class="mt-10 bg-white shadow rounded-xl p-6">

            <h3 class="text-lg font-semibold mb-2">
                🔗 Link público del negocio
            </h3>

            <p class="text-sm text-gray-600 mb-4">
                Compartí este enlace con tus clientes para que puedan reservar turnos.
            </p>

            <div class="flex flex-col sm:flex-row gap-3">

                <input id="link-negocio" type="text" readonly value="{{ route('negocios.show', $negocio->slug) }}"
                    class="w-full rounded-md border-gray-300 bg-gray-50 text-sm">

                <div class="flex gap-2">

                    <button onclick="copiarLink()"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm">
                        Copiar
                    </button>

                    <a href="https://wa.me/?text={{ urlencode('Reservá acá 👉 ' . route('negocios.show', $negocio->slug)) }}"
                        target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm">
                        WhatsApp
                    </a>

                </div>

            </div>
        </div>

        {{-- Selector de rango --}}
        <form method="GET" class="flex items-center gap-3 mt-10 mb-6">

            <span class="text-sm text-gray-600">Rango:</span>

            @foreach ([7 => '7 días', 30 => '30 días', 90 => '90 días'] as $valor => $label)
                <button type="button" data-dias="{{ $valor }}"
                    class="px-3 py-1 rounded-lg text-sm font-medium
    {{ request('dias', 7) == $valor ? 'bg-indigo-600 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                    {{ $label }}
                </button>
            @endforeach

        </form>

        {{-- Gráficas --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="font-semibold mb-3">📊 Turnos por día</h3>
                <canvas id="turnosPorDia"></canvas>
            </div>

            <div class="bg-white shadow rounded-xl p-6">
                <h3 class="font-semibold mb-3">💼 Turnos por servicio</h3>
                <canvas id="turnosPorServicio"></canvas>
            </div>

        </div>


        {{-- Accesos rápidos --}}
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">

            <a href="{{ route('negocios.admin.turnos', $negocio) }}"
                class="group bg-indigo-600 text-white p-6 rounded-xl hover:bg-indigo-700 transition">
                <h3 class="text-lg font-semibold text-center mb-1">Turnos</h3>
                <p class="text-indigo-100 text-center text-sm">
                    Ver y gestionar turnos del negocio
                </p>
            </a>

            <a href="{{ route('negocios.admin.servicios', $negocio) }}"
                class="group bg-green-600 text-white p-6 rounded-xl hover:bg-green-700 transition">
                <h3 class="text-lg font-semibold text-center mb-1">Servicios</h3>
                <p class="text-green-100 text-center text-sm">
                    Crear y administrar servicios
                </p>
            </a>

            <a href="{{ route('negocios.admin.empleados', $negocio) }}"
                class="group bg-gray-700 text-white p-6 rounded-xl hover:bg-gray-800 transition">
                <h3 class="text-lg font-semibold text-center mb-1">Empleados</h3>
                <p class="text-gray-300 text-center text-sm">
                    Gestionar equipo y permisos
                </p>
            </a>

        </div>

    </div>

    {{-- Script copiar --}}
    <script>
        function copiarLink() {
            const input = document.getElementById('link-negocio');
            input.select();
            input.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(input.value);

            alert('Link copiado 📋');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctxDia = document.getElementById('turnosPorDia');
        const ctxServicio = document.getElementById('turnosPorServicio');

        let chartDia = new Chart(ctxDia, {
            type: 'line',
            data: {
                labels: @json($turnosPorDia->pluck('dia')),
                datasets: [{
                    label: 'Turnos',
                    data: @json($turnosPorDia->pluck('total')),
                    tension: 0.4,
                    fill: true
                }]
            }
        });

        let chartServicio = new Chart(ctxServicio, {
            type: 'bar',
            data: {
                labels: @json($turnosPorServicio->pluck('nombre')),
                datasets: [{
                    label: 'Cantidad',
                    data: @json($turnosPorServicio->pluck('total'))
                }]
            }
        });
    </script>


    <script>
        document.querySelectorAll('[data-dias]').forEach(btn => {

            btn.addEventListener('click', async () => {

                const dias = btn.dataset.dias;

                const url = "{{ route('negocios.admin.stats', $negocio) }}" + "?dias=" + dias;

                const res = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!res.ok) {
                    console.error('Error HTTP:', res.status);
                    return;
                }

                const data = await res.json();

                // Turnos por día
                chartDia.data.labels = data.turnosPorDia.map(i => i.dia);
                chartDia.data.datasets[0].data = data.turnosPorDia.map(i => i.total);
                chartDia.update();

                // Turnos por servicio
                chartServicio.data.labels = data.turnosPorServicio.map(i => i.nombre);
                chartServicio.data.datasets[0].data = data.turnosPorServicio.map(i => i.total);
                chartServicio.update();

                // Resaltar botón activo
                document.querySelectorAll('[data-dias]').forEach(b => {
                    b.classList.remove('bg-indigo-600', 'text-white');
                    b.classList.add('bg-gray-200');
                });

                btn.classList.remove('bg-gray-200');
                btn.classList.add('bg-indigo-600', 'text-white');

            });

        });
    </script>
@endsection
