@extends('layouts.app')

@section('content')

    <div class="max-w-6xl mx-auto p-6">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">

            {{-- Acciones izquierda --}}
            <div class="flex gap-3">

                <a href="{{ route('superadmin.usuarios.index') }}"
                    class="px-4 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700">
                    Volver
                </a>

                {{-- Impersonar --}}
                <form method="POST" action="{{ route('superadmin.usuarios.impersonar', $usuario) }}">
                    @csrf
                    <button class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
                        Entrar como usuario
                    </button>
                </form>

                {{-- Suspender / Activar --}}
                <form method="POST" action="{{ route('superadmin.usuarios.toggle', $usuario) }}"
                    onsubmit="return confirm('¿Cambiar estado del usuario?')">

                    @csrf
                    @method('PATCH')

                    <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                        {{ $usuario->estado === 'activo' ? 'Suspender Usuario' : 'Activar Usuario' }}
                    </button>
                </form>

            </div>
        </div>


        {{-- DATOS PERSONALES --}}
        <div class="bg-white shadow rounded-lg p-6 mb-8">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-4">

                <h2 class="text-lg font-semibold">
                    Datos del usuario
                </h2>

                <a href="{{ route('superadmin.usuarios.edit', $usuario) }}"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700">
                    Editar perfil
                </a>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

                <div><strong>Nombre:</strong> {{ $usuario->nombre }}</div>
                <div><strong>Apellido:</strong> {{ $usuario->apellido }}</div>
                <div><strong>Email:</strong> {{ $usuario->email }}</div>

                <div>
                    <strong>Estado:</strong>
                    <span
                        class="px-2 py-1 rounded text-xs
                {{ $usuario->estado === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $usuario->estado }}
                    </span>
                </div>

                <div>
                    <strong>Creado:</strong>
                    {{ $usuario->created_at->format('d/m/Y') }}
                </div>

            </div>

        </div>


        {{-- NEGOCIOS --}}
        <div class="bg-white shadow rounded-lg p-6">

            <h2 class="text-lg font-semibold mb-4">
                Negocios asociados
            </h2>

            @if ($usuario->negocios->isEmpty())
                <p class="text-gray-500">
                    No pertenece a ningún negocio.
                </p>
            @else
                <table class="w-full text-sm border">

                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2">Negocio</th>
                            <th class="p-2">Rol</th>
                            <th class="p-2">Estado</th>
                            <th class="p-2">Cambiar Rol</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($usuario->negocios as $negocio)
                            <tr class="border-t">

                                <td class="p-2 font-medium text-center">
                                    {{ $negocio->nombre }}
                                </td>

                                <td class="p-2 text-center">
                                    {{ optional($roles->firstWhere('id', $negocio->pivot->id_rol))->nombre ?? '—' }}
                                </td>

                                <td class="p-2 text-center">
                                    <span
                                        class="px-2 py-1 rounded
                                {{ $negocio->estado === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $negocio->estado }}
                                    </span>
                                </td>

                                {{-- ACCIONES --}}
                                <td class="p-2 text-center">

                                    <div class="flex justify-center gap-2">

                                        {{-- Cambiar rol --}}
                                        <form method="POST"
                                            action="{{ route('superadmin.usuarios.negocios.rol', [$usuario, $negocio]) }}"
                                            class="flex gap-2">

                                            @csrf
                                            @method('PATCH')

                                            <select name="id_rol" class="border rounded p-1 text-sm">
                                                @foreach ($roles as $r)
                                                    <option value="{{ $r->id }}" @selected($r->id == $negocio->pivot->id_rol)>
                                                        {{ $r->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <button
                                                class="px-3 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700">
                                                Guardar
                                            </button>
                                        </form>

                                        {{-- Quitar --}}
                                        <form method="POST"
                                            action="{{ route('superadmin.usuarios.negocios.quitar', [$usuario, $negocio]) }}"
                                            onsubmit="return confirm('¿Quitar del negocio?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                                Quitar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            {{-- ASIGNAR NUEVO --}}
            @if ($negociosDisponibles->count())
                <div class="mt-6 border-t pt-4">

                    <h3 class="font-semibold mb-2">
                        Asignar a nuevo negocio
                    </h3>

                    <form method="POST"
                        action="{{ route('superadmin.usuarios.negocios.agregar', $usuario) }}"class="flex gap-3">
                        @csrf

                        <select name="id_negocio" class="border p-2 rounded">

                            @foreach ($negociosDisponibles as $n)
                                <option value="{{ $n->id }}">
                                    {{ $n->nombre }}
                                </option>
                            @endforeach

                        </select>

                        <select name="id_rol" class="border p-2 rounded">

                            @foreach ($roles as $r)
                                <option value="{{ $r->id }}">
                                    {{ $r->nombre }}
                                </option>
                            @endforeach

                        </select>
                        <button class="bg-green-600 text-white px-4 rounded">
                            Asignar
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
