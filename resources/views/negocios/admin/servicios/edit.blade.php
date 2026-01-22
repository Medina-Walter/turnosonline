@extends('layouts.app')

@section('title', 'Editar Servicio')

@section('content')
    <div class="w-full bg-white rounded-2xl shadow-xl p-10 max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('negocios.servicios.index', $negocio) }}"
                class="block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
                Volver
            </a>

            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800">Editar Servicio</h1>
                <p class="text-gray-500 mt-2">Actualiza los datos del servicio</p>
            </div>
        </div>

        <!-- Formulario -->
        <form method="POST" action="{{ route('negocios.servicios.update', [$negocio, $servicio]) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nombre del servicio -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre del servicio *
                </label>
                <input type="text" name="nombre" value="{{ old('nombre', $servicio->nombre) }}" required
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                @error('nombre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Descripción -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Descripción
                </label>
                <textarea name="descripcion" rows="3"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                @error('descripcion')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Duración y Precio (lado a lado) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Duración (minutos) *
                    </label>
                    <select name="duracion" required
                        class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Seleccionar duración</option>
                        @foreach ([15, 30, 45, 60, 90, 120] as $duracion)
                            <option value="{{ $duracion }}"
                                {{ old('duracion', $servicio->duracion) == $duracion ? 'selected' : '' }}>
                                {{ $duracion < 60 ? $duracion . ' minutos' : $duracion / 60 . ' hora(s)' }}
                            </option>
                        @endforeach
                    </select>
                    @error('duracion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Precio *
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                        <input type="number" name="precio" min="0" step="0.01"
                            value="{{ old('precio', $servicio->precio) }}" required
                            class="w-full pl-8 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    @error('precio')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buffers y configuraciones adicionales -->
            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                <h3 class="font-medium text-gray-900">Configuraciones adicionales</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Buffer antes (min)
                        </label>
                        <input type="number" name="buffer_antes" min="0" max="60"
                            value="{{ old('buffer_antes', $servicio->buffer_antes) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="text-xs text-gray-500 mt-1">Tiempo libre antes del turno</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Buffer después (min)
                        </label>
                        <input type="number" name="buffer_despues" min="0" max="60"
                            value="{{ old('buffer_despues', $servicio->buffer_despues) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="text-xs text-gray-500 mt-1">Tiempo libre después del turno</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="requiere_seña" value="1"
                            {{ old('requiere_seña', $servicio->requiere_seña) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Requiere seña para confirmar</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" name="activo" value="1"
                            {{ old('activo', $servicio->activo) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Servicio activo (visible para reservas)</span>
                    </label>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="submit"
                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection
