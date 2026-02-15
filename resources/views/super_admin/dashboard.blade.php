@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">

        <h1 class="text-2xl font-bold mb-6">
            Panel Super Admin
        </h1>

        {{-- KPIs --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white shadow rounded-lg p-5">
                <p class="text-sm text-gray-500">Negocios</p>
                <p class="text-3xl font-bold" id="kpi-negocios"></p>
            </div>

            <div class="bg-white shadow rounded-lg p-5">
                <p class="text-sm text-gray-500">Usuarios</p>
                <p class="text-3xl font-bold" id="kpi-usuarios"></p>
            </div>

            <div class="bg-white shadow rounded-lg p-5">
                <p class="text-sm text-gray-500">Usuarios Activos</p>
                <p class="text-3xl font-bold text-green-600" id="kpi-activos"></p>
            </div>

            <div class="bg-white shadow rounded-lg p-5">
                <p class="text-sm text-gray-500">Usuarios Suspendidos</p>
                <p class="text-3xl font-bold text-red-600" id="kpi-suspendidos"></p>
            </div>

        </div>

        {{-- ACCESOS RÁPIDOS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">

            <a href="{{ route('superadmin.negocios.index') }}"
                class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition border-l-4 border-indigo-600">

                <h3 class="font-semibold text-lg mb-2">
                    🏪 Negocios
                </h3>

                <p class="text-gray-600">
                    Ver y administrar todos los negocios creados.
                </p>
            </a>

            <a href="{{ route('superadmin.usuarios.index') }}"
                class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition border-l-4 border-green-600">

                <h3 class="font-semibold text-lg mb-2">
                    👤 Usuarios
                </h3>

                <p class="text-gray-600">
                    Gestionar usuarios del sistema.
                </p>
            </a>

        </div>


        {{-- SELECTOR --}}
        <div class="mt-10 flex gap-3">

            @foreach ([7, 30, 90] as $d)
                <button data-dias="{{ $d }}"
                    class="btn-range bg-gray-200 px-4 py-2 rounded hover:bg-indigo-600 hover:text-white">
                    Últimos {{ $d }} días
                </button>
            @endforeach

        </div>

        {{-- GRÁFICOS --}}
        <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-8">

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold mb-4">Turnos por día</h3>
                <canvas id="chartTurnosDia"></canvas>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold mb-4">Top negocios</h3>
                <canvas id="chartTurnosNegocio"></canvas>
            </div>

        </div>

    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let chartDia;
        let chartNegocio;

        // cargar inicial
        loadDashboard(7);

        document.querySelectorAll('.btn-range').forEach(btn => {
            btn.addEventListener('click', () => {
                loadDashboard(btn.dataset.dias);
            });
        });

        function loadDashboard(dias) {

            fetch(`{{ route('superadmin.dashboard.data') }}?dias=${dias}`)
                .then(res => res.json())
                .then(data => {

                    // KPIs
                    document.getElementById('kpi-negocios').innerText = data.totalNegocios;
                    document.getElementById('kpi-usuarios').innerText = data.totalUsuarios;
                    document.getElementById('kpi-activos').innerText = data.negociosActivos;
                    document.getElementById('kpi-suspendidos').innerText = data.negociosSuspendidos;

                    renderCharts(data);
                });
        }

        function renderCharts(data) {

            // ---- Line ----
            const dias = data.turnosPorDia.map(i => i.dia);
            const totales = data.turnosPorDia.map(i => i.total);

            if (chartDia) chartDia.destroy();

            chartDia = new Chart(
                document.getElementById('chartTurnosDia'), {
                    type: 'line',
                    data: {
                        labels: dias,
                        datasets: [{
                            label: 'Turnos',
                            data: totales,
                            tension: 0.3
                        }]
                    }
                }
            );

            // ---- Bar ----
            const negocios = data.turnosPorNegocio.map(i => i.nombre);
            const totalesNegocio = data.turnosPorNegocio.map(i => i.total);

            if (chartNegocio) chartNegocio.destroy();

            chartNegocio = new Chart(
                document.getElementById('chartTurnosNegocio'), {
                    type: 'bar',
                    data: {
                        labels: negocios,
                        datasets: [{
                            label: 'Turnos',
                            data: totalesNegocio,
                        }]
                    }
                }
            );
        }
    </script>
@endpush
