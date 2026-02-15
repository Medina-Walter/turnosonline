<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Str;

class PlanService
{
    public function all()
    {
        return Plan::orderBy('precio')->get();
    }

    public function create(array $data): Plan
    {
        return Plan::create([
            'nombre' => $data['nombre'],
            'slug' => Str::slug($data['nombre']),
            'precio' => $data['precio'],
            'duracion_dias' => $data['duracion_dias'],
            'max_negocios' => $data['max_negocios'] ?? null,
            'max_empleados' => $data['max_empleados'] ?? null,
            'agenda_inteligente' => $data['agenda_inteligente'] ?? false,
            'reportes' => $data['reportes'] ?? false,
        ]);
    }

    public function update(Plan $plan, array $data): Plan
    {
        return tap($plan)->update([
            'nombre' => $data['nombre'],
            'slug' => Str::slug($data['nombre']),
            'precio' => $data['precio'],
            'duracion_dias' => $data['duracion_dias'],
            'max_negocios' => $data['max_negocios'] ?? null,
            'max_empleados' => $data['max_empleados'] ?? null,
            'agenda_inteligente' => $data['agenda_inteligente'] ?? false,
            'reportes' => $data['reportes'] ?? false,
        ]);
    }

    public function delete(Plan $plan): void
    {
        $plan->delete();
    }
}
