@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6">

        <a href="{{ route('superadmin.negocios.index') }}"
            class="inline-block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
            Volver
        </a>

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">

            <div>
                <h1 class="text-2xl font-bold">
                    {{ $negocio->nombre }}
                </h1>

                <p class="text-sm text-gray-500">
                    {{ $negocio->rubro }} • creado {{ $negocio->created_at->format('d/m/Y') }}
                </p>
            </div>

        </div>

        {{-- DATOS GENERALES --}}
        <div class="grid md:grid-cols-3 gap-6 mb-8">

            <div class="bg-white shadow rounded-xl p-5">
                <h3 class="font-semibold text-center mb-2">Datos</h3>

                <p><strong>Nombre:</strong> {{ $negocio->nombre }}</p>
                <p><strong>Rubro:</strong> {{ $negocio->rubro }}</p>
                <p><strong>Tel:</strong> {{ $negocio->telefono }}</p>
                <p><strong>Dirección:</strong> {{ $negocio->direccion }}</p>
                <p><strong>Estado:</strong>
                    <span
                        class="px-2 py-1 rounded text-xs
                    {{ $negocio->estado === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $negocio->estado }}
                    </span>
                </p>
            </div>

            <div class="bg-white shadow rounded-xl p-5">
                <h3 class="font-semibold text-center mb-2">Usuarios</h3>

                <p>Total: {{ $negocio->usuarios->count() }}</p>

                <ul class="text-sm mt-2 space-y-1">
                    @foreach ($negocio->usuarios as $u)
                        <li>
                            {{ $u->nombre }}
                            <span class="text-xs text-gray-500">
                                (rol {{ $u->rolEnNegocio($negocio)?->nombre ?? '-' }})
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white shadow rounded-xl p-5">
                <h3 class="font-semibold text-center mb-2">Horarios</h3>

                @foreach ($negocio->horarios->groupBy('dia_semana') as $dia => $hs)
                    <div class="text-sm">
                        <strong>
                            {{ [
                                0 => 'Domingo',
                                1 => 'Lunes',
                                2 => 'Martes',
                                3 => 'Miércoles',
                                4 => 'Jueves',
                                5 => 'Viernes',
                                6 => 'Sábado',
                            ][$dia] ?? $dia }}:
                        </strong>

                        @foreach ($hs as $h)
                            {{ $h->hora_inicio }} - {{ $h->hora_fin }}
                        @endforeach
                    </div>
                @endforeach
            </div>

        </div>

        {{-- MÉTRICAS RÁPIDAS --}}
        <h1 class="text-2xl font-bold text-center">
            Turnos
        </h1>
        <div class="overflow-x-auto mt-4">
            <table class="w-full bg-white rounded-xl shadow text-sm">
                <thead class="bordertext-gray-500">
                    <tr>
                        <th class="text-center px-6 py-4 text-base">Fecha</th>
                        <th class="text-center px-6 py-4 text-base">Hora</th>
                        <th class="text-center px-6 py-4 text-base">Nombre</th>
                        <th class="text-center px-6 py-4 text-base">Apellido</th>
                        <th class="text-center px-6 py-4 text-base">Servicio</th>
                    </tr>
                </thead>
                <tbody>


                    @forelse($negocio->turnos as $turno)
                        <tr class="border-b hover:bg-indigo-50 transition mt-3">
                            <td class="text-center px-6 py-5">{{ \Carbon\Carbon::parse($turno->fecha)->format('d/m/Y') }}
                            </td>
                            <td class="text-center px-6 py-5">
                                {{ \Carbon\Carbon::parse($turno->hora_inicio)->format('h:i A') }}
                                -
                                {{ \Carbon\Carbon::parse($turno->hora_fin)->format('h:i A') }}
                            </td>
                            <td class="text-center px-6 py-5">{{ $turno->usuario->nombre ?? '---' }}</td>
                            <td class="text-center px-6 py-5">{{ $turno->usuario->apellido ?? '---' }}</td>
                            <td class="text-center px-6 py-5">{{ $turno->servicio->nombre ?? '---' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">No hay turnos aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
