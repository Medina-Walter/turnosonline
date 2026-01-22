@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-16">

        <!-- HERO -->
        <div class="text-center mb-14">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Reservá turnos en segundos
            </h1>
            <p class="text-gray-600 text-lg mb-4">
                Encontrá tu negocio y elegí el mejor horario disponible
            </p>
        </div>

        <!-- BUSCADOR -->
        <form method="GET" action="{{ route('home') }}" class="mb-12">
            <div class="flex flex-col md:flex-row gap-4">
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Buscar por nombre, rubro o dirección"
                    class="w-full md:flex-1 px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />

                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700">
                    Buscar
                </button>
            </div>
        </form>

        <!-- RESULTADOS -->
        @if (isset($negocios))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($negocios as $negocio)
                    <a href="{{ route('cliente.index', $negocio) }}"
                        class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 block">

                        <h3 class="text-xl font-semibold text-gray-800">
                            {{ $negocio->nombre }}
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $negocio->rubro }}
                        </p>

                        <p class="text-sm text-gray-400 mt-2">
                            {{ $negocio->direccion }}
                        </p>

                        <span class="inline-block mt-4 text-indigo-600 font-semibold">
                            Reservar Turno
                        </span>
                    </a>
                @empty
                    <p class="col-span-full text-center text-gray-500">
                        No se encontraron negocios.
                    </p>
                @endforelse
            </div>
        @endif

    </div>
@endsection
