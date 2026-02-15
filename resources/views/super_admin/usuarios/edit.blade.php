@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">
                Editar Usuario
            </h1>
        </div>

        {{-- Form --}}
        <div class="bg-white p-6 rounded shadow">

            <form method="POST" action="{{ route('superadmin.usuarios.update', $usuario) }}" class="space-y-4">

                @csrf
                @method('PATCH')

                <div>
                    <label class="block font-semibold">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block font-semibold">Apellido</label>
                    <input type="text" name="apellido" value="{{ old('apellido', $usuario->apellido) }}"
                        class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                        class="w-full border rounded p-2">
                </div>

                <hr class="my-6">

                <div>
                    <label class="block font-semibold">Nueva contraseña</label>
                    <input type="password" name="password" class="w-full border rounded p-2">
                </div>

                <div>
                    <label class="block font-semibold">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" class="w-full border rounded p-2">
                </div>


                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('superadmin.usuarios.show', $usuario) }}" class="px-4 py-2 bg-gray-300 rounded">
                        Cancelar
                    </a>

                    <button class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">
                        Guardar cambios
                    </button>
                </div>

            </form>

        </div>
    </div>
@endsection
