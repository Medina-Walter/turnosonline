@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6">

        <h1 class="text-2xl font-bold mb-6">
            Usuarios del sistema
        </h1>

        <div class="bg-white shadow rounded-lg overflow-hidden">

            <table class="w-full">

                <thead class="bg-gray-100 text-sm">
                    <tr>
                        <th class="p-3 text-center">Nombre</th>
                        <th class="p-3 text-center">Apellido</th>
                        <th class="p-3 text-center">Email</th>
                        <th class="p-3 text-center">Estado</th>
                        <th class="p-3 text-center">Negocios</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr class="border-t">

                            <td class="p-3 text-center">
                                {{ $usuario->nombre }}
                            </td>

                            <td class="p-3 text-center">
                                {{ $usuario->apellido }}
                            </td>

                            <td class="p-3 text-center">{{ $usuario->email }}</td>

                            <td class="p-3 text-center">
                                <span
                                    class="px-2 py-1 rounded text-xs
                                {{ $usuario->estado === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $usuario->estado }}
                                </span>
                            </td>

                            <td class="p-3 text-center">
                                {{ $usuario->negocios->count() }}
                            </td>

                            <td class="p-3 text-center">

                                <a href="{{ route('super_admin.usuarios.show', $usuario->id) }}"
                                    class="text-indigo-600 hover:underline">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

        <div class="mt-6">
            {{ $usuarios->links() }}
        </div>

    </div>
@endsection
