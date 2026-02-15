<?php

namespace App\Services;

use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoService
{
    public function crearSuscripcion($email, $plan, $suscripcionId)
    {
        // 1. Asegúrate de que config/services.php tenga el token mapeado a MP_ACCESS_TOKEN
        MercadoPagoConfig::setAccessToken(
            config('services.mercadopago.token')
        );

        $client = new PreferenceClient();

        // 2. Forzamos la URL de Ngrok desde el .env para evitar que use 'localhost'
        // Debe coincidir EXACTAMENTE con tu route:list: api/mercadopago/webhook
        $notificationUrl = rtrim(config('app.url'), '/') . '/api/mercadopago/webhook';

        return $client->create([
            "items" => [
                [
                    "title" => "Plan: " . $plan->nombre,
                    "quantity" => 1,
                    "unit_price" => (float) $plan->precio,
                    "currency_id" => "ARS", // Recomendado para evitar ambigüedad en Argentina
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

            "auto_return" => "approved", // Redirige automáticamente al usuario al finalizar
            "notification_url" => $notificationUrl, // URL corregida con /api/
        ]);
    }
}
