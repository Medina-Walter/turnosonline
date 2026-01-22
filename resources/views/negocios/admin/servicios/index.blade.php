@extends('layouts.app')

@section('title', 'Servicios')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Servicios</h1>
        <a class="inline-block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700"
            href="{{ route('negocios.servicios.create', $negocio) }}">
            Nuevo servicio
        </a>
    </div>

    @if ($servicios->isEmpty())
        <div class="bg-white p-8 rounded-lg shadow text-center text-gray-500">
            No hay servicios registrados para este negocio.
        </div>
    @else
        <a href="{{ route('negocios.admin.dashboard', $negocio) }}"
            class="inline-block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
            Volver
        </a>
        <div class="overflow-x-auto rounded-lg">

            <table class="min-w-full divide-y divide-gray-200 bg-white">

                <thead>
                    <tr>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Descripción</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Duración</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Precio</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Buffer antes</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Buffer después</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($servicios as $servicio)
                        <tr>
                            <td class="px-6 py-4 text-center">
                                <div class="font-semibold text-gray-900">{{ $servicio->nombre }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ $servicio->descripcion ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">{{ $servicio->duracion }} min</td>
                            <td class="px-6 py-4 text-center">
                                @if ($servicio->precio !== null)
                                    ${{ number_format($servicio->precio, 2, ',', '.') }}
                                @else
                                    <span class="text-gray-400">A consultar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">{{ $servicio->buffer_antes ?? 0 }} min</td>
                            <td class="px-6 py-4 text-center">{{ $servicio->buffer_despues ?? 0 }} min</td>

                            <!-- ESTADO -->
                            <td class="px-6 py-4 text-center">
                                @if ($servicio->activo)
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-600 text-xs rounded-full font-bold">Activo</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-gray-200 text-gray-600 text-xs rounded-full font-bold">Inactivo</span>
                                @endif
                            </td>

                            <!-- ACCIONES -->
                            <td class="py-2 text-center">
                                <!-- Activar/Desactivar -->
                                <form action="{{ route('negocios.servicios.toggle', [$negocio, $servicio]) }}"
                                    method="POST" class="inline-block ml-1">
                                    @csrf
                                    @method('PATCH')
                                    @if ($servicio->activo)
                                        <button type="submit" class="text-yellow-600 hover:underline font-medium"
                                            onclick="return confirm('¿Seguro que deseas desactivar este servicio?')">
                                            Desactivar
                                        </button>
                                    @else
                                        <button type="submit" class="text-green-600 hover:underline font-medium"
                                            onclick="return confirm('¿Seguro que deseas activar este servicio?')">
                                            Activar
                                        </button>
                                    @endif
                                </form>
                                <!-- Editar -->
                                <a href="{{ route('negocios.servicios.edit', [$negocio, $servicio]) }}"
                                    class="inline-block text-indigo-600 hover:underline font-medium ml-2">
                                    Editar
                                </a>
                                <!-- Eliminar -->
                                <form action="{{ route('negocios.servicios.destroy', [$negocio, $servicio]) }}"
                                    method="POST" class="inline-block ml-1"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este servicio?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500 hover:underline font-medium">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Si usás paginación -->
        <div class="mt-6">
            {{ $servicios->links() }}
        </div>
    @endif
@endsection
