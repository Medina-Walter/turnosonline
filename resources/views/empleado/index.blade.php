@extends('layouts.app')

@section('title', 'Empleados')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Empleados</h1>

        <a href="{{ route('empleados.create') }}"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">
            + Nuevo empleado
        </a>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <form action="{{ route('empleados.index') }}" method="GET" class="flex items-center gap-2">
            <input type="text" name="buscar" placeholder="Buscar empleado..."
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none w-64"
                value="{{ request('buscar') }}">
            <button class="bg-indigo-500 text-white px-3 py-2 rounded-lg hover:bg-indigo-600 transition">
                Buscar
            </button>
        </form>

        <form method="GET" action="{{ route('empleados.index') }}">
            <select name="estado" onchange="this.form.submit()"
                class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <option value="">Todos</option>
                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activos</option>
                <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivos</option>
            </select>
        </form>
    </div>

    <!-- Tabla de empleados -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full table-auto">
            <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Nombre</th>
                    <th class="px-6 py-3 text-left font-semibold">Email</th>
                    <th class="px-6 py-3 text-left font-semibold">Rol</th>
                    <th class="px-6 py-3 text-left font-semibold">Estado</th>
                    <th class="px-6 py-3 text-center font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($empleados as $empleado)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $empleado->nombre }}</td>
                        <td class="px-6 py-4">{{ $empleado->email }}</td>
                        <td class="px-6 py-4 capitalize">{{ $empleado->rol }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="px-3 py-1 rounded-full text-sm font-medium {{ $empleado->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $empleado->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center flex justify-center gap-2">
                            <a href="{{ route('empleados.show', $empleado) }}"
                                class="text-indigo-600 hover:underline font-medium">Ver</a>
                            <a href="{{ route('empleados.edit', $empleado) }}"
                                class="text-blue-600 hover:underline font-medium">Editar</a>
                            <form action="{{ route('empleados.destroy', $empleado) }}" method="POST"
                                onsubmit="return confirm('¿Seguro que quieres eliminar a este empleado?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-medium">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay empleados registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
