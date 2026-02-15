<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Suscripcion;
use Illuminate\Http\Request;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

class WebhookController extends Controller
{
    public function mercadopago(Request $request)
    {
        if ($request->type !== 'payment') {
            return response()->json(['ok' => true]);
        }

        if (!isset($request->data['id'])) {
            return response()->json(['ok' => true]);
        }

        MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));

        $paymentId = $request->data['id'];

        $client = new PaymentClient();
        $payment = $client->get($paymentId);

        if ($payment->status !== 'approved') {
            return response()->json(['ok' => true]);
        }

        // Evitar duplicados
        if (Pago::where('referencia', $payment->id)->exists()) {
            return response()->json(['ok' => true]);
        }

        $suscripcionId = $payment->external_reference;
        $suscripcion = Suscripcion::find($suscripcionId);

        if (!$suscripcion) {
            return response()->json(['error' => 'Suscripción no encontrada'], 404);
        }

        $suscripcion->update([
            'estado' => 'activa',
            'vence_en' => now()->addMonth(),
        ]);

        Pago::create([
            'id_usuario' => $suscripcion->id_usuario,
            'id_suscripcion' => $suscripcion->id,
            'monto' => $payment->transaction_amount,
            'moneda' => $payment->currency_id,
            'proveedor' => 'mercadopago',
            'referencia' => $payment->id,
            'estado' => 'pagado',
            'pagado_en' => now(),
        ]);

        return response()->json(['ok' => true]);
    }
}
