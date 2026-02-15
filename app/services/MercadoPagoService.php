<?php

namespace App\Services;

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoService
{
    public function crearSuscripcion($email, $plan, $suscripcionId)
    {
        MercadoPagoConfig::setAccessToken(
            config('services.mercadopago.token')
        );

        $client = new PreferenceClient();

        return $client->create([
            "items" => [
                [
                    "title" => $plan->nombre,
                    "quantity" => 1,
                    "unit_price" => (float) $plan->precio,
                ]
            ],
            "payer" => [
                "email" => $email,
            ],
            "external_reference" => (string) $suscripcionId,

            "back_urls" => [
                "success" => route('suscripciones.success'),
                "failure" => route('suscripciones.failure'),
            ],

            "notification_url" => url('/webhook/mercadopago'),
        ]);
    }
}
