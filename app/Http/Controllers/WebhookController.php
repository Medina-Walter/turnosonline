<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Suscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Exceptions\MPApiException;

class WebhookController extends Controller
{
    public function mercadopago(Request $request)
    {
        // 1. Validación rápida del tipo de evento
        if (($request->type ?? $request->topic) !== 'payment') {
            return response()->json(['ok' => true], 200);
        }

        $paymentId = $request->data['id'] ?? $request->id;

        // 2. Manejo del ID de prueba para evitar el Error 500
        if (!$paymentId || $paymentId == "123456") {
            Log::info("Webhook de prueba detectado (ID: 123456).");
            return response()->json(['ok' => true], 200);
        }

        try {
            MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));
            $client = new PaymentClient();
            $payment = $client->get($paymentId);

            if ($payment->status !== 'approved') {
                return response()->json(['ok' => true], 200);
            }

            // 3. Uso de Transacción para integridad de datos
            DB::transaction(function () use ($payment) {
                // Evitar duplicados
                if (Pago::where('referencia', $payment->id)->exists()) {
                    return;
                }

                $suscripcion = Suscripcion::findOrFail($payment->external_reference);

                // Actualizar suscripción
                $suscripcion->update([
                    'estado' => 'activa',
                    'vence_en' => now()->addMonth(),
                ]);

                // Registrar el pago
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
            });

            return response()->json(['ok' => true], 200);
        } catch (MPApiException $e) {
            Log::error("Error de API Mercado Pago: " . $e->getMessage());
            return response()->json(['error' => 'Pago no encontrado'], 200);
        } catch (\Exception $e) {
            Log::error("Error crítico en Webhook: " . $e->getMessage());
            return response()->json(['error' => 'Error interno'], 200);
        }
    }
}
