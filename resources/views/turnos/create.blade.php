@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-6">

        <h1 class="text-3xl font-bold mb-1">
            Reservar turno
        </h1>
        <p class="text-gray-500 mb-4">
            Elegí el servicio y el horario que mejor te quede
        </p>

        <form method="POST" action="{{ route('turnos.store') }}" class="bg-white shadow rounded-xl p-8 space-y-4">
            @csrf

            <!-- NEGOCIO -->
            <div>
                <a href="{{ route('cliente.index') }}"
                    class="inline-block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
                    Volver
                </a>

                <label class="block text-sm font-medium mb-1">
                    Negocio
                </label>
                <select name="id_negocio" id="negocio" required
                    class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccionar negocio</option>
                    @foreach ($negocios as $negocio)
                        <option value="{{ $negocio->id }}">
                            {{ $negocio->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- SERVICIO -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Servicio
                </label>
                <select name="id_servicio" id="servicio" required
                    class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccionar servicio</option>
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}" data-duracion="{{ $servicio->duracion }}">
                            {{ $servicio->nombre }} ({{ $servicio->duracion }} min)
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- FECHA -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Fecha
                </label>
                <input type="date" name="fecha" id="fecha" required
                    class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- HORA -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Hora
                </label>

                <div id="horas-container" class="grid grid-cols-4 gap-2"></div>

                <input type="hidden" name="hora_inicio" id="hora_inicio">
            </div>

            <!-- BOTÓN -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                    Confirmar turno
                </button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    <script>
        const negocioSelect = document.querySelector('[name="id_negocio"]');
        const servicioSelect = document.querySelector('[name="id_servicio"]');
        const fechaInput = document.querySelector('[name="fecha"]');

        const horasContainer = document.getElementById('horas-container');
        const horaHidden = document.getElementById('hora_inicio');

        let duracionServicio = 30;

        // 👇 cuando cambia servicio
        servicioSelect.addEventListener('change', e => {
            const opt = e.target.selectedOptions[0];
            const match = opt.textContent.match(/\((\d+)/);
            if (match) duracionServicio = parseInt(match[1]);

            cargarDisponibilidad();
        });

        // 👇 cuando cambia negocio o fecha
        [negocioSelect, fechaInput].forEach(el => {
            el.addEventListener('change', cargarDisponibilidad);
        });

        async function cargarDisponibilidad() {

            horasContainer.innerHTML = '';
            horaHidden.value = '';

            if (!negocioSelect.value || !fechaInput.value) return;

            const url = `/negocios/${negocioSelect.value}/disponibilidad/${fechaInput.value}?t=${Date.now()}`;

            const res = await fetch(url, {
                cache: "no-store"
            });
            const data = await res.json();

            generarHoras(data);
        }

        function generarHoras(data) {

            horasContainer.innerHTML = '';

            if (data.cerrado) {
                horasContainer.innerHTML =
                    `<p class="text-red-600 font-semibold col-span-4">El negocio está cerrado este día</p>`;
                return;
            }

            let [h, m] = data.hora_inicio.split(':').map(Number);
            const [hf, mf] = data.hora_fin.split(':').map(Number);

            while (h < hf || (h === hf && m < mf)) {

                const hora = `${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}`;

                const ocupado = data.ocupados.some(r =>
                    hora >= r.hora_inicio && hora < r.hora_fin
                );

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = hora;

                btn.className =
                    'border rounded-lg py-2 text-sm font-semibold ' +
                    (ocupado ?
                        'bg-gray-200 text-gray-400 cursor-not-allowed' :
                        'bg-white hover:bg-indigo-100');

                btn.disabled = ocupado;

                btn.addEventListener('click', () => {
                    document.querySelectorAll('#horas-container button')
                        .forEach(b => b.classList.remove('ring', 'ring-indigo-500'));

                    btn.classList.add('ring', 'ring-indigo-500');
                    horaHidden.value = hora;
                });

                horasContainer.appendChild(btn);

                m += duracionServicio;
                if (m >= 60) {
                    m = 0;
                    h++;
                }
            }
        }
    </script>
@endpush
