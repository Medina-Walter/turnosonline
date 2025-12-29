@extends('layouts.app')

@section('title', 'Reservar Turno')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Reservar Turno</h2>

    <form method="POST" action="{{ route('turnos.store') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="id_negocio" value="{{ $negocio->id }}">
        <input type="hidden" name="id_cliente" value="{{ $cliente->id }}">

        <div>
            <label class="block text-sm font-medium">Servicio</label>
            <select name="id_servicio" class="w-full mt-1 border rounded px-3 py-2">
                @foreach($servicios as $servicio)
                    <option value="{{ $servicio->id }}">
                        {{ $servicio->nombre }} ({{ $servicio->duracion }} min)
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Fecha</label>
            <input type="date" name="fecha" class="w-full mt-1 border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium">Hora</label>
            <input type="time" name="hora_inicio" class="w-full mt-1 border rounded px-3 py-2">
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Confirmar Turno
        </button>
    </form>
</div>
@endsection
