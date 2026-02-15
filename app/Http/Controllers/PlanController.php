<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Services\PlanService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct(
        protected PlanService $planService
    ) {}

    public function index()
    {
        $planes = $this->planService->all();

        return view('super_admin.planes.index', compact('planes'));
    }

    public function create()
    {
        return view('super_admin.planes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|integer|min:0',
            'duracion_dias' => 'required|integer|min:1',

            'max_negocios' => 'nullable|integer|min:1',
            'max_empleados' => 'nullable|integer|min:1',

            'agenda_inteligente' => 'sometimes|boolean',
            'reportes' => 'sometimes|boolean',
        ]);

        $this->planService->create($data);

        return redirect()
            ->route('superadmin.planes.index')
            ->with('success', 'Plan creado correctamente');
    }

    public function edit(Plan $plan)
    {
        return view('super_admin.planes.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|integer|min:0',
            'duracion_dias' => 'required|integer|min:1',

            'max_negocios' => 'nullable|integer|min:1',
            'max_empleados' => 'nullable|integer|min:1',

            'agenda_inteligente' => 'sometimes|boolean',
            'reportes' => 'sometimes|boolean',
        ]);

        $this->planService->update($plan, $data);

        return redirect()
            ->route('superadmin.planes.index')
            ->with('success', 'Plan actualizado correctamente');
    }

    public function destroy(Plan $plan)
    {
        $this->planService->delete($plan);

        return back()->with('success', 'Plan eliminado');
    }
}
