<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $planes = [
            [
                'nombre' => 'Gratis',
                'slug' => 'gratis',
                'descripcion' => 'Para empezar sin compromiso',
                'precio' => 0,
                'features' => [
                    '1 negocio',
                    '1 empleado',
                    'Agenda básica',
                    'Reservas online 24/7',
                    'Página pública del negocio',
                    'Cancelación de turnos',
                ],
            ],
            [
                'nombre' => 'Pro',
                'slug' => 'pro',
                'descripcion' => 'Para negocios que quieren crecer',
                'precio' => 10990,
                'features' => [
                    'Negocios ilimitados',
                    'Empleados ilimitados',
                    'Agenda inteligente',
                    'Gestión de clientes',
                    'Estadísticas',
                    'Panel administrativo completo',
                    'Soporte prioritario',
                ],
            ],
        ];

        foreach ($planes as $plan) {
            Plan::updateOrCreate(
                ['slug' => $plan['slug']],
                [
                    'nombre' => $plan['nombre'],
                    'descripcion' => $plan['descripcion'],
                    'precio' => $plan['precio'],
                    'features' => $plan['features'],
                    'activo' => true,
                ]
            );
        }
    }
}
