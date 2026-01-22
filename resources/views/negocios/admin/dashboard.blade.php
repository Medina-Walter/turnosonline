@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">
        <a href="{{ route('negocios.index') }}"
            class="inline-block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
            Volver
        </a>
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ $negocio->nombre }}</h1>
            <p class="text-gray-600">Panel de administración del negocio</p>
        </div>

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

        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('negocios.admin.turnos', $negocio) }}"
                class="group bg-indigo-600 text-white p-6 rounded-xl hover:bg-indigo-700 transition">
                <h3 class="text-lg font-semibold text-center mb-1">Turnos</h3>
                <p class="text-indigo-100 text-center text-sm">Ver y gestionar turnos del negocio</p>
            </a>

            <a href="{{ route('negocios.admin.servicios', $negocio) }}"
                class="group bg-green-600 text-white p-6 rounded-xl hover:bg-green-700 transition">
                <h3 class="text-lg font-semibold text-center mb-1">Servicios</h3>
                <p class="text-green-100 text-center text-sm">Crear y administrar servicios</p>
            </a>

            <a href="{{ route('negocios.admin.empleados', $negocio) }}" class="group bg-gray-700 text-white p-6 rounded-xl hover:bg-gray-800 transition">
                <h3 class="text-lg font-semibold text-center mb-1">Empleados</h3>
                <p class="text-gray-300 text-center text-sm">Gestionar equipo y permisos</p>
            </a>
        </div>
    </div>
@endsection
