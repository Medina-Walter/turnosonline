@extends('layouts.app')

@section('content')
    <div class="container mx-auto">

        <a href="{{ route('cliente.index') }}"
            class="inline-block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
            Volver
        </a>
        <h1 class="text-2xl mb-6 font-bold">Mis negocios</h1>

        <div class="mb-6">
            <a href="{{ route('negocios.create') }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded font-semibold hover:bg-indigo-700">
                + Nuevo Negocio
            </a>
        </div>

        @php
            $dias = [
                0 => 'Domingo',
                1 => 'Lunes',
                2 => 'Martes',
                3 => 'Miércoles',
                4 => 'Jueves',
                5 => 'Viernes',
                6 => 'Sábado',
            ];
        @endphp

        @forelse($negocios as $negocio)
            <div class="shadow rounded-xl p-4 mb-6 bg-white">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="font-bold text-lg">
                            {{ $negocio->nombre }}
                            <span class="font-normal text-gray-800">
                                ({{ $negocio->rubro }})
                            </span>
                        </div>

                        <div class="text-sm text-gray-800">
                            Tel: {{ $negocio->telefono }} | {{ $negocio->direccion }}
                        </div>
                    </div>

                    <div class="flex gap-2">

                        {{-- Botón editar --}}
                        <a href="{{ route('negocios.edit', $negocio) }}"
                            class="inline-flex items-center gap-1 bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                            Editar
                        </a>

                        {{-- Botón eliminar --}}
                        <form action="{{ route('negocios.destroy', $negocio) }}" method="POST"
                            onsubmit="return confirm('¿Seguro que querés eliminar este negocio?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="inline-flex items-center gap-1 bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition">
                                Eliminar
                            </button>
                        </form>

                    </div>
                </div>

                <div class="mt-4 text-gray-800">
                    <span class="font-semibold text-gray-800">Horarios:</span>
                    <div class="whitespace-pre-line">
                        @foreach ($dias as $dnum => $dname)
                            @php
                                $franjas = $negocio->horarios->where('dia_semana', $dnum);
                            @endphp
                            @if ($franjas->count())
                                <span class="font-semibold">{{ $dname }}:</span>
                                @foreach ($franjas as $f)
                                    {{ substr($f->hora_inicio, 0, 5) }}-{{ substr($f->hora_fin, 0, 5) }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                                <br>
                            @endif
                        @endforeach
                    </div>
                </div>
                <!-- Servicios del negocio -->
                <div class="mt-3">
                    <a href="{{ route('negocios.admin.dashboard', $negocio) }}"
                        class="inline-block mt-2 bg-indigo-600 text-white px-4 py-2 rounded font-semibold hover:bg-indigo-700">
                        Administrar Negocio
                    </a>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-800">Aún no tienes negocios registrados.</div>
        @endforelse
    </div>
@endsection
