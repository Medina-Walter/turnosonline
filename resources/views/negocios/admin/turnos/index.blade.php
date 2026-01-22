@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-10">
        <a href="{{ route('negocios.admin.dashboard', $negocio) }}"
            class="inline-block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
            Volver
        </a>

        <h1 class="text-2xl font-bold mb-4">Turnos para <span class="text-gray-800">{{ $negocio->nombre }}</span></h1>

        <div class="overflow-x-auto">
            <table class="w-full bg-white rounded-xl shadow text-sm">
                <thead class="border-b text-gray-500">
                    <tr>
                        <th class="text-center px-6 py-4 text-base font-semibold">Fecha</th>
                        <th class="text-center px-6 py-4 text-base font-semibold">Hora</th>
                        <th class="text-center px-6 py-4 text-base font-semibold">Nombre</th>
                        <th class="text-center px-6 py-4 text-base font-semibold">Apellido</th>
                        <th class="text-center px-6 py-4 text-base font-semibold">Servicio</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($turnos as $turno)
                        <tr class="border-b hover:bg-indigo-50 transition">
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
                            <td colspan="5" class="py-8 text-center text-gray-500">No hay turnos asignados aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
