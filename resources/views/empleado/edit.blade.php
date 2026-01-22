@extends('layouts.app')

@section('title', 'Editar Empleado')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Editar empleado</h1>
        <p class="text-gray-500">Actualizá los datos del empleado.</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('empleados.update', $empleado) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $empleado->nombre) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <!-- Email -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $empleado->email) }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <!-- Rol -->
            <div>
                <label class="block font-medium text-gray-700 mb-1">Rol</label>
                <select name="rol"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Seleccionar</option>
                    <option value="empleado" {{ old('rol', $empleado->rol) == 'empleado' ? 'selected' : '' }}>Empleado
                    </option>
                    <option value="admin" {{ old('rol', $empleado->rol) == 'admin' ? 'selected' : '' }}>Administrador
                    </option>
                </select>
            </div>

            <!-- Activo -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="activo" value="1" id="activo"
                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                    {{ old('activo', $empleado->activo) ? 'checked' : '' }}>
                <label for="activo" class="text-gray-700">Activo</label>
            </div>

            <!-- Botones -->
            <div class="flex items-center gap-3">
                <button type="submit"
                    class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">
                    Guardar cambios
                </button>

                <a href="{{ route('empleados.index') }}"
                    class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
@endsection
