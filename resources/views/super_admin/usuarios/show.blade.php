@extends('layouts.app')

@section('content')

    <div class="max-w-6xl mx-auto p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">
                Usuario #{{ $usuario->id }}
            </h1>

            <a href="{{ route('superadmin.usuarios.index') }}" class="text-gray-600 hover:underline">
                ← Volver
            </a>
        </div>

        {{-- Datos personales --}}
        <div class="bg-white shadow rounded-lg p-6 mb-8">

            <h2 class="text-lg font-semibold mb-4">Datos del usuario</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                <div><strong>Nombre:</strong> {{ $usuario->nombre }}</div>
                <div><strong>Apellido:</strong> {{ $usuario->apellido }}</div>
                <div><strong>Email:</strong> {{ $usuario->email }}</div>
                <div><strong>Estado:</strong>
                    <span
                        class="px-2 py-1 rounded text-xs
                    {{ $usuario->estado === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $usuario->estado }}
                    </span>
                </div>

                <div><strong>Creado:</strong> {{ $usuario->created_at->format('d/m/Y') }}</div>

            </div>
        </div>

        {{-- Negocios --}}
        <div class="bg-white shadow rounded-lg p-6">

            <h2 class="text-lg font-semibold mb-4">Negocios asociados</h2>

            @if ($usuario->negocios->isEmpty())
                <p class="text-gray-500">No pertenece a ningún negocio.</p>
            @else
                <table class="w-full text-sm border">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2">Negocio</th>
                            <th class="p-2">Rol</th>
                            <th class="p-2">Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($usuario->negocios as $negocio)
                            <tr class="border-t">

                                <td class="p-2 font-medium">
                                    {{ $negocio->nombre }}
                                </td>

                                <td class="p-2">
                                    {{ $negocio->pivot->id_rol }}
                                </td>

                                <td class="p-2">
                                    <span
                                        class="px-2 py-1 rounded text-xs
                                    {{ $negocio->estado === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $negocio->estado }}
                                    </span>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            @endif
        </div>

    </div>

@endsection
