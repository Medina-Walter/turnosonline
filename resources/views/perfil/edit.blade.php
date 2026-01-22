@extends('layouts.app')

@section('title', 'Editar perfil')

@section('content')
    <div class="max-w-2xl mx-auto px-6 py-6">
        <h1 class="text-3xl font-bold mb-6">Editar perfil</h1>

        <div class="bg-white rounded-xl shadow p-8">
            <form action="{{ route('perfil.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <label for="nombre" class="block text-sm text-gray-700 font-medium mb-1">
                        Nombre
                    </label>
                    <input id="nombre" type="text" name="nombre" value="{{ old('nombre', Auth::user()->nombre) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        required>
                    @error('nombre')
                        <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="apellido" class="block text-sm text-gray-700 font-medium mb-1">
                        Apellido
                    </label>
                    <input id="apellido" type="text" name="apellido"
                        value="{{ old('apellido', Auth::user()->apellido) }}"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                        required>
                    @error('apellido')
                        <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('perfil.index') }}"
                        class="mr-3 inline-block bg-gray-200 text-gray-800 px-5 py-2 rounded-lg font-semibold hover:bg-gray-300 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-block bg-indigo-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
