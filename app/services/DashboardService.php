<?php

namespace App\Services;

use App\Models\Negocio;
use App\Models\Usuario;

class DashboardService
{
    public function getStats(): array
    {
        return [
            'negocios'             => Negocio::count(),
            'usuarios'             => Usuario::count(),
            'negocios_activos'     => Negocio::where('estado', 'activo')->count(),
            'negocios_suspendidos' => Negocio::where('estado', 'suspendido')->count(),
        ];
    }
}
