<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Suscripcion;
use App\Services\MercadoPagoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuscripcionController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        $suscripcion = $usuario->suscripcion ?? null;

        $planActual = $suscripcion?->id_plan;

        $planes = Plan::where('activo', true)
            ->orderBy('precio')
            ->get();

        return view('suscripciones.index', compact(
            'planes',
            'planActual',
            'suscripcion'
        ));
    }

    /**
     * 🚀 Contratar plan (redirige a MercadoPago)
     */
    public function cambiarPlan(Request $request, MercadoPagoService $mp)
    {
        $request->validate([
            'id_plan' => 'required|exists:planes,id',
        ]);

        $usuario = Auth::user();
        $plan = Plan::findOrFail($request->id_plan);

        $suscripcion = Suscripcion::updateOrCreate(
            ['id_usuario' => $usuario->id],
            [
                'id_plan' => $plan->id,
                'estado' => 'pendiente',
                'inicia_en' => now(),
            ]
        );

        try {
            $preference = $mp->crearSuscripcion(
                $usuario->email,
                $plan,
                $suscripcion->id
            );

            return redirect($preference->init_point);
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTrace());
        }
    }




    public function success()
    {
        return view('suscripciones.success');
    }

    public function failure()
    {
        return view('suscripciones.failure');
    }
}
