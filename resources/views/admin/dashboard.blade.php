@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">

        <h1 class="text-3xl font-bold mb-2">
            {{ $negocio->nombre }}
        </h1>
        <p class="text-gray-600 mb-8">
            Panel de administración del negocio
        </p>

        <!-- MÉTRICAS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white shadow rounded-xl p-5">
                <p class="text-gray-500 text-sm">Turnos hoy</p>
                <p class="text-3xl font-bold">12</p>
            </div>

            <div class="bg-white shadow rounded-xl p-5">
                <p class="text-gray-500 text-sm">Pendientes</p>
                <p class="text-3xl font-bold">5</p>
            </div>

            <div class="bg-white shadow rounded-xl p-5">
                <p class="text-gray-500 text-sm">Empleados</p>
                <p class="text-3xl font-bold">3</p>
            </div>

            <div class="bg-white shadow rounded-xl p-5">
                <p class="text-gray-500 text-sm">Servicios</p>
                <p class="text-3xl font-bold">6</p>
            </div>

        </div>

        <!-- ACCESOS RÁPIDOS -->
        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">

            <a href="{{ route('admin.turnos.index', $negocio) }}"
                class="bg-indigo-600 text-white p-6 rounded-xl hover:bg-indigo-700">
                <h3 class="text-lg font-semibold">📅 Turnos</h3>
                <p class="text-indigo-100 text-sm">Ver y gestionar turnos</p>
            </a>

            <a href="{{ route('admin.servicios.index', $negocio) }}"
                class="bg-green-600 text-white p-6 rounded-xl hover:bg-green-700">
                <h3 class="text-lg font-semibold">🛠 Servicios</h3>
                <p class="text-green-100 text-sm">Administrar servicios</p>
            </a>

            <a href="{{ route('admin.empleados.index', $negocio) }}"
                class="bg-gray-700 text-white p-6 rounded-xl hover:bg-gray-800">
                <h3 class="text-lg font-semibold">👥 Empleados</h3>
                <p class="text-gray-300 text-sm">Gestionar equipo</p>
            </a>

        </div>

    </div>
@endsection
