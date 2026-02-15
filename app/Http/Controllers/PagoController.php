<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Suscripcion;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

class PagoController extends Controller
{
    public function webhook(Request $request)
    {
        $data = $request->all();

        if (!isset($data['data']['id'])) {
            return response()->json(['ok' => true]);
        }

        MercadoPagoConfig::setAccessToken(env('MP_ACCESS_TOKEN'));

        $client = new PaymentClient();
        $payment = $client->get($data['data']['id']);

        if ($payment->status === 'approved') {

            $pago = Pago::where('referencia', $payment->id)->first();

            if ($pago) {
                $pago->estado = 'pagado';
                $pago->pagado_en = now();
                $pago->save();

                $suscripcion = Suscripcion::find($pago->id_suscripcion);

                if ($suscripcion) {
                    $suscripcion->estado = 'activa';
                    $suscripcion->inicia_en = now();
                    $suscripcion->vence_en = now()->addMonth();
                    $suscripcion->save();
                }
            }
        }

        return response()->json(['ok' => true]);
    }
}
