<?php

namespace App\Services;

use App\Models\Horario;
use Carbon\Carbon;
use Exception;

class HorarioService
{
    /**
     * Crear o actualizar horario de un día (con campo "activo")
     */
    public function guardarHorario(
        int $idNegocio,
        int $dia_semana,    // 0 = domingo ... 6 = sábado
        string $horaInicio,
        string $horaFin,
        bool $activo = true
    ): Horario {
        if ($horaInicio >= $horaFin) {
            throw new Exception('La hora de apertura debe ser anterior a la de cierre');
        }

        return Horario::updateOrCreate(
            [
                'id_negocio' => $idNegocio,
                'dia_semana' => $dia_semana,
            ],
            [
                'hora_inicio' => $horaInicio,
                'hora_fin'    => $horaFin,
                'activo'      => $activo,
            ]
        );
    }

    /**
     * Verifica si el negocio atiende un día (solo si está activo)
     */
    public function atiendeEsteDia(int $idNegocio, string $fecha): bool
    {
        $diaSemana = Carbon::parse($fecha)->dayOfWeek; // 0 = domingo ... 6 = sábado

        return Horario::where('id_negocio', $idNegocio)
            ->where('dia_semana', $diaSemana)
            ->where('activo', true)
            ->exists();
    }

    /**
     * Obtiene el horario de atención para un día (devuelve null si no hay)
     */
    public function obtenerHorarioDia(int $idNegocio, string $fecha): ?Horario
    {
        $diaSemana = Carbon::parse($fecha)->dayOfWeek;

        return Horario::where('id_negocio', $idNegocio)
            ->where('dia_semana', $diaSemana)
            //->where('activo', true)   // <- Si solo buscas activos, descomentar esta línea.
            ->first();
    }

    /**
     * Valida si un rango horario está dentro del horario de atención de ese día
     *
     * @throws Exception Si el turno no está en el rango correcto o el horario no existe
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

        if (empty($horario->hora_inicio) || empty($horario->hora_fin)) {
            throw new Exception('El horario de atención para este día no está correctamente configurado.');
        }

        $apertura = Carbon::parse($horario->hora_inicio);
        $cierre   = Carbon::parse($horario->hora_fin);
        $inicio   = Carbon::parse($horaInicio);
        $fin      = Carbon::parse($horaFin);

        if ($inicio->lt($apertura) || $fin->gt($cierre)) {
            throw new Exception(
                'El horario del turno está fuera del horario de atención (' .
                    $apertura->format('H:i') . ' - ' .
                    $cierre->format('H:i') . ')'
            );
        }
    }
}
