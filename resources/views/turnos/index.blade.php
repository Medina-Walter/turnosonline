@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-10">

        <!-- HEADER -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-800">
                👋 Hola, {{ auth()->user()->nombre }}
            </h1>
            <p class="text-gray-500 mt-1">
                Reservá tu próximo turno en segundos
            </p>
        </div>

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
                        <th class="text-left py-2">Fecha</th>
                        <th class="text-left py-2">Hora</th>
                        <th class="text-left py-2">Negocio</th>
                        <th class="text-left py-2">Servicio</th>
                        <th class="text-left py-2">Estado</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($turnos as $turno)
                        <tr>
                            <td class="py-2">{{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y') }}</td>
                            <td class="py-2">
                                {{ substr($turno->hora_inicio, 0, 5) }} - {{ substr($turno->hora_fin, 0, 5) }}
                            </td>
                            <td class="py-2">{{ $turno->negocio->nombre ?? '-' }}</td>
                            <td class="py-2">{{ $turno->servicio->nombre ?? '-' }}</td>
                            <td class="py-2">
                                @if ($turno->estado === 'pendiente')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pendiente</span>
                                @elseif($turno->estado === 'confirmado')
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Confirmado</span>
                                @elseif($turno->estado === 'cancelado')
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Cancelado</span>f
                            </td>
                            <td class="py-2">
                                @if ($turno->estado === 'pendiente')
                                    <form method="POST" action="{{ route('turnos.cancelar', $turno->id) }}">
                                        @csrf
                                        <button type="submit" class="text-xs text-red-600 hover:underline"
                                            onclick="return confirm('¿Seguro de cancelar este turno?')">
                                            Cancelar
                                        </button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-500">No tenés turnos agendados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
