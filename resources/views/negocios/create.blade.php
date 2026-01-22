@extends('layouts.app')

@section('content')
    <div class="w-full bg-white rounded-2xl shadow-xl items-center justify-center p-10">

        <!-- Título -->
        <div class="mb-8">
            <a href="{{ route('cliente.index') }}"
                class="block w-36 text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 mb-4">
                Volver
            </a>

            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800">Creá tu negocio</h1>
                <p class="text-gray-500 mt-2">Configurá tu negocio para comenzar a recibir turnos</p>
            </div>
        </div>

        <!-- Formulario -->
        <form method="POST" action="{{ route('negocios.store') }}" class="space-y-6">
            @csrf

            <!-- Nombre -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre del negocio
                </label>
                <input type="text" name="nombre" value="{{ old('nombre') }}" required placeholder="Ej: Barbería Central"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                @error('nombre')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Rubro -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Rubro
                </label>
                <input type="text" name="rubro" value="{{ old('rubro') }}"
                    placeholder="Ej: Peluquería, Consultorio, Gimnasio..."
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                <p class="text-xs text-gray-400 mt-1">
                    Podés escribir lo que mejor describa tu negocio
                </p>
            </div>

            <!-- Teléfono -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Teléfono de contacto
                </label>
                <input type="text" name="telefono" value="{{ old('telefono') }}" placeholder="Ej: 11 2345 6789"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Dirección -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Dirección
                </label>
                <input type="text" name="direccion" value="{{ old('direccion') }}" placeholder="Ej: Av. Siempre Viva 123"
                    class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Horarios de atención -->
            <div>
                <p class="text-center text-gray-800 mt-4">
                    Cada día puede tener más de un horario. Usá “+ Franja” para agregar rangos horarios partido.
                </p>
                <label class="block text-lg font-bold text-gray-700 mt-4">Horarios de atención</label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start auto-rows-min">
                    @php
                        $dias = [
                            0 => 'Domingo',
                            1 => 'Lunes',
                            2 => 'Martes',
                            3 => 'Miércoles',
                            4 => 'Jueves',
                            5 => 'Viernes',
                            6 => 'Sábado',
                        ];
                    @endphp
                    @foreach ($dias as $num => $dia)
                        <div class="border rounded-xl p-4 flex flex-col gap-2 h-fit">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="font-semibold text-gray-700">{{ $dia }}</span>
                                <button type="button" onclick="agregarFranja({{ $num }})"
                                    class="ml-auto bg-indigo-600 text-white px-2 py-1 rounded text-xs">+ Franja</button>
                            </div>
                            <div id="franjas-dia-{{ $num }}">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-1">
                                    <input type="time" name="horarios[{{ $num }}][0][hora_inicio]"
                                        class="border rounded px-2 py-1 text-sm w-full sm:w-32" placeholder="Abre">
                                    <span class="block sm:inline">-</span>
                                    <input type="time" name="horarios[{{ $num }}][0][hora_fin]"
                                        class="border rounded px-2 py-1 text-sm w-full sm:w-32" placeholder="Cierra">
                                    <button type="button" onclick="eliminarFranja(this, {{ $num }})"
                                        class="ml-0 sm:ml-2 text-red-500 text-xs w-fit">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <script>
                function agregarFranja(dia) {
                    const container = document.getElementById('franjas-dia-' + dia);
                    let idx = 0;
                    while (container.querySelector(`[name="horarios[${dia}][${idx}][hora_inicio]"]`)) idx++;
                    const div = document.createElement('div');
                    div.className = 'flex flex-col sm:flex-row sm:items-center gap-2 mb-1';
                    div.innerHTML = `
                        <input type="time" name="horarios[${dia}][${idx}][hora_inicio]" class="border rounded px-2 py-1 text-sm w-full sm:w-32" placeholder="Abre">
                        <span class="block sm:inline">-</span>
                        <input type="time" name="horarios[${dia}][${idx}][hora_fin]" class="border rounded px-2 py-1 text-sm w-full sm:w-32" placeholder="Cierra">
                        <button type="button" class="ml-0 sm:ml-2 text-red-500 text-xs w-fit" onclick="eliminarFranja(this, ${dia})">Eliminar</button>
                    `;
                    container.appendChild(div);
                }

                function eliminarFranja(boton, dia) {
                    const container = document.getElementById('franjas-dia-' + dia);
                    boton.parentElement.remove();
                    // Si no quedó ninguna franja, agregamos una vacía automáticamente
                    if (container.children.length === 0) agregarFranja(dia);
                }
            </script>

            <!-- Botón -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition">
                    Continuar
                </button>
            </div>
        </form>
    </div>
@endsection
