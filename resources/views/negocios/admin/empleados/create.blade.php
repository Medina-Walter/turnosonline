@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">

        <div class="bg-white shadow rounded-lg">
            <div class="border-b px-6 py-4 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-900">
                    Nuevo empleado – {{ $negocio->nombre }}
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

                <form action="{{ route('negocios.admin.empleados.store', $negocio) }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Nombre --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Nombre
                        </label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    {{-- Apellido --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Apellido
                        </label>
                        <input type="text" name="apellido" value="{{ old('apellido') }}"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Contraseña
                        </label>
                        <input type="password" name="password"
                            class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    {{-- Info --}}
                    <div class="rounded-md bg-gray-50 p-4 text-sm text-gray-600">
                        El empleado será creado con rol <strong>Empleado</strong> y
                        quedará asociado automáticamente a este negocio.
                    </div>

                    {{-- Botones --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('negocios.admin.empleados', $negocio) }}"
                            class="rounded-md bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300">
                            Cancelar
                        </a>

                        <button type="submit"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                            Crear empleado
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
