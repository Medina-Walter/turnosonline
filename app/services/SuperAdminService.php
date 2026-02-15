<?php

namespace App\Services;

use App\Models\Negocio;
use App\Models\Turno;
use App\Models\Usuario;
use Carbon\Carbon;

class SuperAdminService
{
    public function stats(int $dias = 7): array
    {
        $desde = Carbon::now()->subDays($dias);

        return [
            // Totales
            'totalNegocios' => Negocio::count(),
            'totalUsuarios' => Usuario::count(),

            // Estados de negocios
            'negociosActivos' =>
            Negocio::where('estado', 'activo')->count(),

            'negociosSuspendidos' =>
            Negocio::where('estado', 'suspendido')->count(),

            // Estadísticas
            'turnosPorDia' => $this->turnosPorDia($desde),

            'turnosPorNegocio' => $this->turnosPorNegocio($desde),

            'dias' => $dias
        ];
    }

    protected function turnosPorDia(Carbon $desde)
    {
        return Turno::whereDate('fecha', '>=', $desde)
            ->selectRaw('DATE(fecha) dia, COUNT(*) total')
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();
    }

    protected function turnosPorNegocio(Carbon $desde)
    {
        return Turno::whereDate('fecha', '>=', $desde)
            ->join('negocios', 'turnos.id_negocio', '=', 'negocios.id')
            ->selectRaw('negocios.nombre, COUNT(*) total')
            ->groupBy('negocios.nombre')
            ->orderByDesc('total')
            ->limit(10)
            ->get();
    }
}
