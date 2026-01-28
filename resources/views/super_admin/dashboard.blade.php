@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-8">

        <h1 class="text-2xl font-bold mb-6">
            Panel Super Admin
        </h1>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white shadow rounded-lg p-5">
                <p class="text-sm text-gray-500">Negocios</p>
                <p class="text-3xl font-bold">{{ $stats['negocios'] }}</p>
            </div>

            <div class="bg-white shadow rounded-lg p-5">
                <p class="text-sm text-gray-500">Usuarios</p>
                <p class="text-3xl font-bold">{{ $stats['usuarios'] }}</p>
            </div>

            <div class="bg-white shadow rounded-lg p-5">
                <p class="text-sm text-gray-500">Activos</p>
                <p class="text-3xl font-bold">{{ $stats['negocios_activos'] }}</p>
            </div>

            <div class="bg-white shadow rounded-lg p-5">
                <p class="text-sm text-gray-500">Suspendidos</p>
                <p class="text-3xl font-bold">{{ $stats['negocios_suspendidos'] }}</p>
            </div>

        </div>

        {{-- Accesos rápidos --}}
        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">

            <a href="{{ route('superadmin.negocios.index') }}"
                class="bg-indigo-600 text-white p-6 rounded-lg shadow hover:bg-indigo-700 transition">
                Gestionar negocios
            </a>

            <a href="{{ route('superadmin.usuarios.index') }}"
                class="bg-emerald-600 text-white p-6 rounded-lg shadow hover:bg-emerald-700 transition">
                Usuarios globales
            </a>

            <a href="{{ route('superadmin.roles.index') }}"
                class="bg-slate-700 text-white p-6 rounded-lg shadow hover:bg-slate-800 transition">
                Roles y permisos
            </a>

        </div>

    </div>
@endsection
