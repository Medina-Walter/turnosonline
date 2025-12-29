@extends('layouts.app')

@section('title', 'Crear Negocio')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Nuevo Negocio</h2>

    <form method="POST" action="{{ route('negocios.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Nombre</label>
            <input type="text" name="nombre" class="w-full mt-1 border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium">Teléfono</label>
            <input type="text" name="telefono" class="w-full mt-1 border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" class="w-full mt-1 border rounded px-3 py-2">
        </div>

        <div>
            <label class="block text-sm font-medium">Dirección</label>
            <input type="text" name="direccion" class="w-full mt-1 border rounded px-3 py-2">
        </div>

        <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
            Guardar
        </button>
    </form>
</div>
@endsection
