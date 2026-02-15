@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-10">

        <!-- CTA -->
        <div class="bg-indigo-600 text-white rounded-xl p-8 mb-10 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h2 class="text-2xl font-semibold">
                    ¿Querés un nuevo turno?
                </h2>
                <p class="text-indigo-100">
                    Elegí el servicio, día y horario disponible
                </p>
            </div>

            <a href="{{ route('turnos.create') }}"
                class="mt-4 md:mt-0 bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">
                Reservar turno
            </a>
        </div>

        <!-- MIS TURNOS -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-semibold mb-4">
                📅 Mis turnos
            </h2>

            <table class="w-full text-sm">
                <thead class="border-b text-gray-500">
                    <tr>
                        <th class="text-center py-2">Fecha</th>
                        <th class="text-center py-2">Hora</th>
                        <th class="text-center py-2">Negocio</th>
                        <th class="text-center py-2">Servicio</th>
                        <th class="text-center py-2">Acción</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($turnos as $turno)
                        <tr>
                            <td class="text-center py-2">{{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y') }}</td>
                            <td class="text-center py-2">
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $turno->hora_inicio)->format('h:i A') }}
                            </td>
                            <td class="text-center py-2">{{ $turno->negocio->nombre ?? '-' }}</td>
                            <td class="text-center py-2">{{ $turno->servicio->nombre ?? '-' }}</td>
                            <td class="text-center py-2">
                                <form method="POST" action="{{ route('turnos.cancelar', $turno->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition"
                                        onclick="return confirm('¿Seguro de cancelar este turno?')">
                                        Cancelar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-800">No tenés turnos agendados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
