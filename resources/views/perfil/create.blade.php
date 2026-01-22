@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-6 py-6">
        <h1 class="text-center text-3xl font-bold mb-1">
            Completa tú perfil
        </h1>
        <p class="text-center text-gray-500 mb-4">
            Antes de reservar un turno, debes ingrsar tu nombre y apellido.
        </p>

        <form method="POST" action="{{ route('perfil.store') }}" class="bg-white shadow rounded-xl p-8 space-y-4">
            @csrf

            <!-- NOMBRE -->
            <div>
                <label for="nombre" class="block text-sm font-medium mb-1">
                    Nombre
                </label>
                <input id="nombre" type="text" name="nombre" value="{{ old('nombre', auth()->user()->nombre) }}"
                    required class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                @error('nombre')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- APELLIDO -->
            <div>
                <label for="apellido" class="block text-sm font-medium mb-1">
                    Apellido
                </label>
                <input id="apellido" type="text" name="apellido" value="{{ old('apellido', auth()->user()->apellido) }}"
                    required class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                @error('apellido')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- BOTÓN -->
            <div class="pt-4">
                <button class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                    Guardar datos
                </button>
            </div>
        </form>
    </div>
@endsection
