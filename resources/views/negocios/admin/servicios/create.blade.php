@extends('layouts.app')

@section('content')
    <div class="w-full bg-white rounded-2xl shadow-xl p-10">

        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('negocios.servicios.index', $negocio) }}"
                class="block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
                Volver
            </a>

            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800">Crear Servicio</h1>
                <p class="text-gray-500 mt-2">Define los servicios que ofrece tu negocio</p>
            </div>
        </div>

        <!-- Formulario -->
        <form method="POST" action="{{ route('negocios.servicios.store', $negocio) }}" class="space-y-6">
            @csrf

            <!-- Nombre del servicio -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre del servicio *
                </label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required
                    placeholder="Ej: Corte de cabello, Consulta médica, Clase de yoga..."
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
                <textarea name="descripcion" rows="3" placeholder="Descripción opcional del servicio..."
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('descripcion') }}</textarea>
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
                        <option value="15" {{ old('duracion') == 15 ? 'selected' : '' }}>15 minutos</option>
                        <option value="30" {{ old('duracion') == 30 ? 'selected' : '' }}>30 minutos</option>
                        <option value="45" {{ old('duracion') == 45 ? 'selected' : '' }}>45 minutos</option>
                        <option value="60" {{ old('duracion') == 60 ? 'selected' : '' }}>1 hora</option>
                        <option value="90" {{ old('duracion') == 90 ? 'selected' : '' }}>1h 30min</option>
                        <option value="120" {{ old('duracion') == 120 ? 'selected' : '' }}>2 horas</option>
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
                        <input type="number" name="precio" value="{{ old('precio') }}" required min="0"
                            step="0.01" placeholder="0.00"
                            class="w-full pl-8 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    @error('precio')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Configuraciones adicionales -->
            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                <h3 class="font-medium text-gray-900">Configuraciones adicionales</h3>

                <!-- Buffer antes/después -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Buffer antes (min)
                        </label>
                        <input type="number" name="buffer_antes" value="{{ old('buffer_antes', 0) }}" min="0"
                            max="60"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="text-xs text-gray-500 mt-1">Tiempo libre antes del turno</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Buffer después (min)
                        </label>
                        <input type="number" name="buffer_despues" value="{{ old('buffer_despues', 0) }}" min="0"
                            max="60"
                            class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="text-xs text-gray-500 mt-1">Tiempo libre después del turno</p>
                    </div>
                </div>

                <!-- Checkboxes -->
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="requiere_seña" value="1"
                            {{ old('requiere_seña') ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Requiere seña para confirmar</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Servicio activo (visible para reservas)</span>
                    </label>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="submit"
                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition">
                    Crear Servicio
                </button>
            </div>

        </form>
    </div>
@endsection
