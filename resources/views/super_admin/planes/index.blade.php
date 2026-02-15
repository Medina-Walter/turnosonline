@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Planes</h1>

    <a href="{{ route('superadmin.planes.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded mb-4 inline-block">
        Nuevo plan
    </a>

    <div class="bg-white rounded shadow overflow-hidden">

        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3">Nombre</th>
                    <th>Precio</th>
                    <th>Días</th>
                    <th>Negocios</th>
                    <th>Empleados</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($planes as $plan)
                    <tr class="border-t">
                        <td class="px-4 py-3 font-semibold">{{ $plan->nombre }}</td>
                        <td>${{ number_format($plan->precio) }}</td>
                        <td>{{ $plan->duracion_dias }}</td>
                        <td>{{ $plan->max_negocios ?? '∞' }}</td>
                        <td>{{ $plan->max_empleados ?? '∞' }}</td>

                        <td class="flex gap-2 px-4 py-2">
                            <a href="{{ route('superadmin.planes.edit', $plan) }}" class="text-indigo-600">Editar</a>

                            <form method="POST" action="{{ route('superadmin.planes.destroy', $plan) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
@endsection
