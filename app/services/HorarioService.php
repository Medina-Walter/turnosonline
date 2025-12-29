<?php

namespace App\Services;

use App\Models\Horario;
use Carbon\Carbon;
use Exception;

class HorarioService
{
    /**
     * Crear o actualizar horario de un día
     */
    public function guardarHorario(
        int $idNegocio,
        int $dia,
        string $horaApertura,
        string $horaCierre
    ): Horario {
        if ($horaApertura >= $horaCierre) {
            throw new Exception('La hora de apertura debe ser menor a la de cierre');
        }

        return Horario::updateOrCreate(
            [
                'id_negocio' => $idNegocio,
                'dia'        => $dia,
            ],
            [
                'hora_apertura' => $horaApertura,
                'hora_cierre'   => $horaCierre,
            ]
        );
    }

    /**
     * Verifica si el negocio atiende un día
     */
    public function atiendeEsteDia(int $idNegocio, string $fecha): bool
    {
        $diaSemana = Carbon::parse($fecha)->dayOfWeekIso;

        return Horario::where('id_negocio', $idNegocio)
            ->where('dia', $diaSemana)
            ->exists();
    }

    /**
     * Obtiene el horario de atención de un día
     */
    public function obtenerHorarioDia(int $idNegocio, string $fecha): ?Horario
    {
        $diaSemana = Carbon::parse($fecha)->dayOfWeekIso;

        return Horario::where('id_negocio', $idNegocio)
            ->where('dia', $diaSemana)
            ->first();
    }

    /**
     * Valida si un rango horario está dentro del horario de atención
     */
    public function validarRangoHorario(
        int $idNegocio,
        string $fecha,
        string $horaInicio,
        string $horaFin
    ): void {
        $horario = $this->obtenerHorarioDia($idNegocio, $fecha);

        if (!$horario) {
            throw new Exception('El negocio no atiende este día');
        }

        if (
            $horaInicio < $horario->hora_apertura ||
            $horaFin > $horario->hora_cierre
        ) {
            throw new Exception('El horario está fuera del horario de atención');
        }
    }
}
