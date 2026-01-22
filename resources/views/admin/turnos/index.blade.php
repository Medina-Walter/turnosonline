@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <!-- TÍTULO -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Agenda de turnos
        </h1>

        <span class="text-gray-500">
            {{ now()->format('d/m/Y') }}
        </span>
    </div>

    <!-- FILTROS -->
    <div class="bg-white rounded-xl shadow p-6 mb-8 flex flex-wrap gap-4">
        <input type="date"
               class="border rounded-lg px-4 py-2"
               value="{{ now()->toDateString() }}">

        <select class="border rounded-lg px-4 py-2">
            <option>Todos los estados</option>
            <option>Pendiente</option>
            <option>Confirmado</option>
            <option>Cancelado</option>
        </select>
    </div>

    <!-- TABLA -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-100 text-gray-600 text-sm uppercase">
                <tr>
                    <th class="px-6 py-4">Hora</th>
                    <th class="px-6 py-4">Cliente</th>
                    <th class="px-6 py-4">Servicio</th>
                    <th class="px-6 py-4">Empleado</th>
                    <th class="px-6 py-4">Estado</th>
                    <th class="px-6 py-4 text-right">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                <!-- Turno ejemplo -->
                <tr>
                    <td class="px-6 py-4 font-semibold">10:00</td>
                    <td class="px-6 py-4">Juan Pérez</td>
                    <td class="px-6 py-4">Corte de pelo</td>
                    <td class="px-6 py-4">María</td>
                    <td class="px-6 py-4">
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                            Pendiente
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <button class="text-indigo-600 hover:underline">
                            Ver
                        </button>
                        <button class="text-green-600 hover:underline">
                            Confirmar
                        </button>
                        <button class="text-red-600 hover:underline">
                            Cancelar
                        </button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

</div>
@endsection
