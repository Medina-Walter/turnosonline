<div class="space-y-4">

    <div>
        <label class="block font-semibold">Nombre</label>
        <input name="nombre" value="{{ old('nombre', $plan->nombre ?? '') }}" class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block font-semibold">Precio</label>
        <input type="number" name="precio" value="{{ old('precio', $plan->precio ?? 0) }}"
            class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block font-semibold">Duración (días)</label>
        <input type="number" name="duracion_dias" value="{{ old('duracion_dias', $plan->duracion_dias ?? 30) }}"
            class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block font-semibold">Máx negocios</label>
        <input type="number" name="max_negocios" value="{{ old('max_negocios', $plan->max_negocios ?? '') }}"
            class="w-full border rounded px-3 py-2">
    </div>

    <div>
        <label class="block font-semibold">Máx empleados</label>
        <input type="number" name="max_empleados" value="{{ old('max_empleados', $plan->max_empleados ?? '') }}"
            class="w-full border rounded px-3 py-2">
    </div>

    <div class="flex gap-6">
        <label>
            <input type="checkbox" name="agenda_inteligente"
                {{ old('agenda_inteligente', $plan->agenda_inteligente ?? false) ? 'checked' : '' }}>
            Agenda inteligente
        </label>

        <label>
            <input type="checkbox" name="reportes" {{ old('reportes', $plan->reportes ?? false) ? 'checked' : '' }}>
            Reportes
        </label>
    </div>

</div>
