@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">

        <div class="bg-white shadow rounded-lg">
            <div class="border-b px-6 py-4 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">
                    Editar empleado – {{ $usuario->nombre }} {{ $usuario->apellido }}
                </h2>
            </div>

            <div class="p-6">

                {{-- Mensajes de error --}}
                @if ($errors->any())
                    <div class="mb-4 rounded bg-red-100 p-4 text-red-700">
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('negocios.admin.empleados.update', [$negocio, $usuario]) }}" method="POST"
                    class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Nombre
                        </label>
                        <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    {{-- Apellido --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Apellido
                        </label>
                        <input type="text" name="apellido" value="{{ old('apellido', $usuario->apellido) }}"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    {{-- Email (solo lectura) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <input type="email" value="{{ $usuario->email }}"
                            class="mt-1 w-full rounded-md border-gray-200 bg-gray-100 shadow-sm" disabled>
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('negocios.admin.empleados', $negocio) }}"
                            class="rounded-md bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300">
                            Cancelar
                        </a>

                        <button type="submit"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                            Guardar cambios
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection
