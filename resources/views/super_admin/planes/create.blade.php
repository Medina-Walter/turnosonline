@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Crear plan</h1>

    <form method="POST" action="{{ route('superadmin.planes.store') }}" class="bg-white p-6 rounded shadow max-w-xl">

        @csrf

        @include('super_admin.planes.partials.form')

        <button class="bg-indigo-600 text-white px-4 py-2 rounded">
            Guardar
        </button>

    </form>
@endsection
