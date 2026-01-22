@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')
    <div class="max-w-2xl mx-auto px-6 py-6">
        <a href="{{ route('cliente.index') }}"
            class="inline-block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
            Volver
        </a>
        <h1 class="text-3xl font-bold mb-4">Perfil de usuario</h1>

        <div class="bg-white rounded-xl shadow p-8 space-y-6">
            <!-- Datos personales -->
            <div>
                <h2 class="text-lg font-semibold mb-3 text-indigo-600">Datos personales</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <div class="text-gray-500 text-sm">Nombre</div>
                        <div class="font-medium text-lg text-gray-800">{{ Auth::user()->nombre }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 text-sm">Apellido</div>
                        <div class="font-medium text-lg text-gray-800">{{ Auth::user()->apellido }}</div>
                    </div>
                </div>
            </div>

            <!-- Botón de editar -->
            <div class="pt-4">
                <a href="{{ route('perfil.edit') }}"
                    class="inline-block bg-indigo-600 text-white px-5 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    Editar perfil
                </a>
            </div>
        </div>
    </div>
@endsection
