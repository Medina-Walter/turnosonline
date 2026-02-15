<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPlan
{
    public function handle(Request $request, Closure $next, ...$planesPermitidos)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 👑 SUPER ADMIN BYPASS
        if ($user->esSuperAdmin()) {
            return $next($request);
        }

        $suscripcion = $user->suscripcion;

        if (!$suscripcion) {
            return redirect()
                ->route('suscripcion.index')
                ->with('error', 'No tenés una suscripción activa.');
        }

        if (in_array($suscripcion->estado, ['vencida', 'cancelada'])) {
            return redirect()
                ->route('suscripcion.index')
                ->with('error', 'Tu suscripción no está activa.');
        }

        $plan = $suscripcion->plan;

        if (!$plan) {
            return redirect()
                ->route('suscripcion.index')
                ->with('error', 'Tu plan no es válido.');
        }

        // 👉 GRATIS solo 1 negocio
        if ($plan->slug === 'gratis') {

            $cantidadNegocios = $user->negocios()->count();

            if ($cantidadNegocios >= 1) {
                return redirect()
                    ->route('suscripcion.index')
                    ->with('error', 'El plan gratis permite solo 1 negocio. Actualizá tu plan.');
            }
        }

        // 👉 Restricción por planes específicos
        if (!empty($planesPermitidos)) {

            if (!in_array($plan->slug, $planesPermitidos)) {
                return redirect()
                    ->route('suscripcion.index')
                    ->with('error', 'Tu plan no incluye esta función.');
            }
        }

        return $next($request);
    }
}
