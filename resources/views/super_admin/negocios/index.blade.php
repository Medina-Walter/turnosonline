@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6">

        <a href="{{ route('superadmin.dashboard') }}"
            class="inline-block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
            Volver
        </a>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">
                Negocios registrados
            </h1>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">

            <table class="min-w-full text-sm">

                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3 text-center">Nombre</th>
                        <th class="p-3 text-center">Rubro</th>
                        <th class="p-3 text-center">Dueño</th>
                        <th class="p-3 text-center">Usuarios</th>
                        <th class="p-3 text-center">Estado</th>
                        <th class="p-3 text-center">Creado</th>
                        <th class="p-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse ($negocios as $negocio)
                        @php
                            $duenio = $negocio->usuarios->first();
                        @endphp

                        <tr>

                            <td class="p-3 font-semibold text-center">
                                {{ $negocio->nombre }}
                            </td>

                            <td class="p-3 text-center">
                                {{ $negocio->rubro }}
                            </td>

                            <td class="p-3 text-center">
                                {{ $duenio?->nombre ?? '-' }}
                            </td>

                            <td class="p-3 text-center">
                                {{ $negocio->usuarios->count() }}
                            </td>

                            <td class="p-3 text-center">

                                <span
                                    class="px-2 py-1 rounded text-xs
                                {{ $negocio->estado === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $negocio->estado }}
                                </span>

                            </td>

                            <td class="p-3 text-center">
                                {{ $negocio->created_at->format('d/m/Y') }}
                            </td>

                            <td class="p-3 text-center space-x-2">

                                <a href="{{ route('superadmin.negocios.show', $negocio) }}"
                                    class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
                                    Ver Detalles
                                </a>

                                <form method="POST" action="{{ route('superadmin.negocios.toggle', $negocio) }}"
                                    class="inline">

                                    @csrf
                                    @method('PATCH')

                                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        {{ $negocio->estado === 'activo' ? 'Suspender' : 'Activar' }}
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-500">
                                No hay negocios registrados.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-6">
            {{ $negocios->links() }}
        </div>


    </div>
@endsection
