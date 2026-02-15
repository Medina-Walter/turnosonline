<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;
use App\Models\Plan;
use App\Models\Suscripcion;
use App\Models\Usuario;
use App\Services\MercadoPagoService;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 🔥 Webhook Mercado Pago
Route::post('/mercadopago/webhook', [WebhookController::class, 'mercadopago']);

// Ruta para generar el link de tu sistema
Route::post('/generar-pago-sistema', function (Illuminate\Http\Request $request, MercadoPagoService $mpService) {
    // 1. Tomamos el primer usuario de tu DB y el plan que envíes
    $usuario = Usuario::first(); 
    $plan = Plan::find($request->id_plan);

    if (!$plan) return response()->json(['error' => 'Plan no encontrado'], 404);

    // 2. Registramos la suscripción en estado 'pendiente'
    $suscripcion = Suscripcion::updateOrCreate(
        ['id_usuario' => $usuario->id],
        [
            'id_plan' => $plan->id,
            'estado' => 'pendiente',
            'inicia_en' => now()
        ]
    );

    try {
        // 3. Llamamos a tu servicio de Mercado Pago
        $preference = $mpService->crearSuscripcion($usuario->email, $plan, $suscripcion->id);

        return response()->json([
            'status' => 'success',
            'plan' => $plan->nombre,
            'monto' => $plan->precio,
            'init_point' => $preference->init_point, // Este es el link que viste en la captura
            'id_suscripcion' => $suscripcion->id
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});