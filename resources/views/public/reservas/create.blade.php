@extends('layouts.public')

@section('title', 'Reservar turno')

@section('content')
    <div class="max-w-xl mx-auto p-8 bg-white shadow rounded-xl">

        <h1 class="text-2xl font-bold mb-6">
            Reservar en {{ $negocio->nombre }}
        </h1>

        <form method="POST" action="{{ route('turnos.store') }}">
            <input type="hidden" name="id_negocio" value="{{ $negocio->id }}">

            @csrf

            {{-- Nombre --}}
            <div class="mb-4">
                <label class="block mb-1 font-medium">Nombre</label>
                <input type="text" name="nombre" class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Teléfono --}}
            <div class="mb-4">
                <label class="block mb-1 font-medium">Teléfono</label>
                <input type="text" name="telefono" class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Servicio --}}
            <div class="mb-4">
                <label class="block mb-1 font-medium">Servicio</label>
                <select name="servicio_id" class="w-full border rounded px-3 py-2">
                    @foreach ($negocio->servicios as $servicio)
                        <option value="{{ $servicio->id }}">
                            {{ $servicio->nombre }} - ${{ $servicio->precio }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Fecha --}}
            <div class="mb-4">
                <label class="block mb-1 font-medium">Fecha</label>
                <input type="date" name="fecha" class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Hora --}}
            <div class="mb-4">
                <label class="block mb-1 font-medium">Hora</label>
                <input type="time" name="hora" class="w-full border rounded px-3 py-2" required>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700">
                Confirmar turno
            </button>
        </form>

    </div>
@endsection
