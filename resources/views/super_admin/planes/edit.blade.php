@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Editar plan</h1>

    <form method="POST" action="{{ route('superadmin.planes.update', $plan) }}" class="bg-white p-6 rounded shadow max-w-xl">

        @csrf
        @method('PUT')

        @include('super_admin.planes.partials.form', ['plan' => $plan])

        <button class="bg-indigo-600 text-white px-4 py-2 rounded">
            Actualizar
        </button>

    </form>
@endsection
