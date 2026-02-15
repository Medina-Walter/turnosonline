@extends('layouts.public')

@section('title', $negocio->nombre)

@section('content')
    <div class="max-w-6xl mx-auto p-8">

        <h1 class="text-3xl font-bold">{{ $negocio->nombre }}</h1>
        <p class="text-gray-600 mt-2">{{ $negocio->descripcion }}</p>

        <div class="grid md:grid-cols-2 gap-6 mt-8">

            {{-- SERVICIOS --}}
            <div>
                <h2 class="text-xl font-semibold mb-4">Servicios</h2>

                @foreach ($negocio->servicios as $servicio)
                    <div class="border rounded-lg p-4 flex justify-between mb-3">
                        <span>{{ $servicio->nombre }}</span>
                        <span class="font-semibold">${{ $servicio->precio }}</span>
                    </div>
                @endforeach
            </div>

            {{-- CTA --}}
            <div class="bg-indigo-600 text-white rounded-xl p-6">
                <h3 class="text-xl font-bold mb-2">Reservar turno</h3>

                <p class="text-indigo-100 mb-4">
                    Elegí el servicio y el horario disponible.
                </p>

                <a class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-semibold" href="{{ route('turnos.create', ['negocio' => $negocio->slug,]) }}">Reservar Turno</a>
            </div>

        </div>

    </div>
@endsection
