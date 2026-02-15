<?php

namespace App\Listeners;

use App\Models\Plan;
use App\Models\Suscripcion;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;

class CreateSuscripcionAfterRegister
{
    public function handle(Registered $event): void
    {
        $usuario = $event->user;

        // Plan inicial
        $plan = Plan::where('slug', 'gratis')->first();

        if (!$plan) {
            return; // fallback si no existe
        }

        $hoy = Carbon::now();

        Suscripcion::create([
            'id_usuario' => $usuario->id,
            'id_plan' => $plan->id,
            'estado' => 'activa',
            'inicia_en' => $hoy,
            'vence_en' => null,
            'trial_hasta' => null,
            'renovacion_automatica' => false,
        ]);
    }
}
