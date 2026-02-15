@extends('layouts.app')

@section('title', 'Planes')

@section('content')


    <div class="max-w-7xl mx-auto px-6 py-16 text-center">

        {{-- Header --}}
        <h1 class="text-4xl font-extrabold mb-3">
            Planes simples para negocios reales
        </h1>

        <p class="text-gray-600 text-lg mb-14">
            Empezá gratis y escalá cuando tu negocio crezca
        </p>

        {{-- Cards --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            @foreach ($planes as $plan)
                @php
                    $esActual = $planActual === $plan->id;
                @endphp


                <div
                    class="relative bg-white rounded-2xl shadow-lg p-8 border transition
                {{ $esActual ? 'border-indigo-600 ring-2 ring-indigo-400 scale-105' : 'border-gray-200 hover:shadow-xl' }}">

                    {{-- Badge PRO --}}
                    @if ($plan->slug === 'pro')
                        <span
                            class="absolute -top-4 left-1/2 -translate-x-1/2 bg-indigo-600 text-white text-xs px-4 py-1 rounded-full shadow">
                            Más elegido
                        </span>
                    @endif

                    {{-- Badge plan actual --}}
                    @if ($esActual)
                        <span class="absolute -top-4 right-4 bg-green-600 text-white text-xs px-3 py-1 rounded-full shadow">
                            Plan actual
                        </span>
                    @endif

                    <h2 class="text-2xl font-bold mb-1">
                        {{ $plan->nombre }}
                    </h2>

                    <p class="text-gray-500 mb-6">
                        {{ $plan->descripcion }}
                    </p>

                    <p class="text-4xl mb-6">
                        ARS {{ number_format($plan->precio, 0, ',', '.') }}

                        @if ($plan->precio > 0)
                            <span class="text-base font-medium text-gray-500">/ mes</span>
                        @endif
                    </p>

                    {{-- Features --}}
                    <ul class="text-sm space-y-3 mb-8 text-left inline-block">
                        @foreach ($plan->features ?? [] as $feature)
                            <li class="flex items-center gap-2">
                                <span class="text-green-600"></span>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>

                    {{-- Button --}}
                    @if ($esActual)
                        <button disabled
                            class="w-full bg-gray-200 text-gray-600 py-3 rounded-lg font-semibold cursor-not-allowed">
                            Plan actual
                        </button>
                    @else
                        <form method="POST" action="{{ route('suscripcion.cambiar') }}">
                            @csrf

                            <input type="hidden" name="id_plan" value="{{ $plan->id }}">

                            <button
                                class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                                Cambiar a {{ $plan->nombre }}
                            </button>
                        </form>
                    @endif

                </div>
            @endforeach

        </div>

    </div>

@endsection
