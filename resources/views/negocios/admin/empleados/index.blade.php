@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-8">

        {{-- Volver --}}
        <a href="{{ route('negocios.admin.dashboard', $negocio) }}"
            class="inline-block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
            Volver
        </a>

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">
                Empleados – {{ $negocio->nombre }}
            </h1>

            <a href="{{ route('negocios.admin.empleados.create', $negocio) }}"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                + Nuevo empleado
            </a>
        </div>

        {{-- Tabla --}}
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-center">Nombre</th>
                        <th class="p-3 text-center">Apellido</th>
                        <th class="p-3 text-center">Email</th>
                        <th class="p-3 text-center">Rol</th>
                        <th class="p-3 text-center">Estado</th>
                        <th class="p-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($empleados as $empleado)
                        <tr>
                            {{-- Nombre --}}
                            <td class="p-3 text-center">
                                {{ $empleado->nombre }}
                            </td>

                            {{-- Nombre --}}
                            <td class="p-3 text-center">
                                {{ $empleado->apellido }}
                            </td>

                            {{-- Email --}}
                            <td class="p-3 text-center">
                                {{ $empleado->email }}
                            </td>

                            {{-- Rol --}}
                            <td class="p-3 text-center">
                                {{ $roles[$empleado->pivot->id_rol] ?? 'Empleado' }}
                            </td>

                            {{-- Estado --}}
                            <td class="p-3 text-center">
                                @if ($empleado->estado === 'activo')
                                    <span
                                        class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Activo
                                    </span>
                                @else
                                    <span
                                        class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                        Inactivo
                                    </span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="p-3 text-center">
                                <div class="flex justify-center gap-2">

                                    {{-- Editar --}}
                                    <a href="{{ route('negocios.admin.empleados.edit', [$negocio, $empleado]) }}"
                                        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-indigo-700">
                                        Editar
                                    </a>

                                    {{-- Activar / Desactivar --}}
                                    <form method="POST"
                                        action="{{ route('negocios.admin.empleados.toggle-estado', [$negocio, $empleado]) }}">
                                        @csrf
                                        @method('PATCH')

                                        @if ($empleado->estado === 'activo')
                                            <button type="submit" onclick="return confirm('¿Desactivar empleado?')"
                                                class="inline-flex items-center rounded-md bg-yellow-500 px-3 py-1.5 text-xs font-semibold text-white hover:bg-yellow-600">
                                                Desactivar
                                            </button>
                                        @else
                                            <button type="submit" onclick="return confirm('¿Activar empleado?')"
                                                class="inline-flex items-center rounded-md bg-green-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-green-700">
                                                Activar
                                            </button>
                                        @endif
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">
                                No hay empleados cargados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
