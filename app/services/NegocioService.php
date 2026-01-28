<?php

namespace App\Services;

use App\Models\Negocio;
use Carbon\Carbon;


class NegocioService
{
    public function obtenerStats(Negocio $negocio, int $dias = 7): array
    {
        $desde = Carbon::now()->subDays($dias);

        return [
            'turnosHoy' => $this->turnosHoy($negocio),
            'empleadosCount' => $this->empleadosCount($negocio),
            'serviciosCount' => $this->serviciosCount($negocio),
            'turnosPorDia' => $this->turnosPorDia($negocio, $desde),
            'turnosPorServicio' => $this->turnosPorServicio($negocio, $desde),
            'dias' => $dias,
        ];
    }

    protected function turnosHoy(Negocio $negocio): int
    {
        return $negocio->turnos()
            ->whereDate('fecha', today())
            ->count();
    }

    protected function empleadosCount(Negocio $negocio): int
    {
        return $negocio->usuarios()
            ->wherePivotIn('id_rol', [2, 3])
            ->count();
    }

    protected function serviciosCount(Negocio $negocio): int
    {
        return $negocio->servicios()
            ->where('activo', true)
            ->count();
    }

    protected function turnosPorDia(Negocio $negocio, Carbon $desde)
    {
        return $negocio->turnos()
            ->whereDate('fecha', '>=', $desde)
            ->selectRaw('DATE(fecha) as dia, count(*) total')
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();
    }

    protected function turnosPorServicio(Negocio $negocio, Carbon $desde)
    {
        return $negocio->turnos()
            ->whereDate('fecha', '>=', $desde)
            ->join('servicios', 'turnos.id_servicio', '=', 'servicios.id')
            ->selectRaw('servicios.nombre as nombre, count(*) total')
            ->groupBy('servicios.nombre')
            ->get();
    }
}
