@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-6">

        <h1 class="text-3xl font-bold mb-1">
            Reservar turno
        </h1>
        <p class="text-gray-500 mb-4">
            Elegí el servicio y el horario que mejor te quede
        </p>

        <form method="POST" action="{{ route('turnos.store') }}" class="bg-white shadow rounded-xl p-8 space-y-4">
            @csrf

            <!-- NEGOCIO -->
            <div>
                <a href="{{ route('cliente.index') }}"
                    class="inline-block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
                    Volver
                </a>

                <label class="block text-sm font-medium mb-1">
                    Negocio
                </label>
                <select name="id_negocio" required
                    class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccionar negocio</option>
                    @foreach ($negocios as $negocio)
                        <option value="{{ $negocio->id }}">
                            {{ $negocio->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- SERVICIO -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Servicio
                </label>
                <select name="id_servicio" required
                    class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Seleccionar servicio</option>
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}">
                            {{ $servicio->nombre }} ({{ $servicio->duracion }} min)
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- FECHA -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Fecha
                </label>
                <input type="date" name="fecha" required
                    class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- HORA -->
            <div>
                <label class="block text-sm font-medium mb-1">
                    Hora
                </label>
                <input type="time" name="hora_inicio" required
                    class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- BOTÓN -->
            <div class="pt-4">
                <button class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                    Confirmar turno
                </button>
            </div>

        </form>
    </div>
@endsection
