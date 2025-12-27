<?php

namespace App\Services;

use App\Models\Turno;
use App\Models\Servicio;
use App\Models\Horario;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class TurnoService
{
    /**
     * Crear un turno aplicando todas las reglas
     */
    public function crear(array $data): Turno
    {
        return DB::transaction(function () use ($data) {

            // 1️⃣ Obtener servicio
            $servicio = Servicio::findOrFail($data['id_servicio']);

            // 2️⃣ Calcular horario fin
            $horaInicio = Carbon::createFromFormat('H:i', $data['hora_inicio']);
            $horaFin = (clone $horaInicio)->addMinutes($servicio->duracion);

            // 3️⃣ Validar horario del negocio
            $this->validarHorarioNegocio(
                $data['id_negocio'],
                $data['fecha'],
                $horaInicio,
                $horaFin
            );

            // 4️⃣ Validar solapamiento
            if ($this->haySolapamiento(
                $data['id_negocio'],
                $data['fecha'],
                $horaInicio->format('H:i'),
                $horaFin->format('H:i')
            )) {
                throw new Exception('El horario seleccionado no está disponible');
            }

            // 5️⃣ Crear turno
            return Turno::create([
                'id_negocio'  => $data['id_negocio'],
                'id_cliente'  => $data['id_cliente'],
                'id_servicio' => $data['id_servicio'],
                'fecha'       => $data['fecha'],
                'hora_inicio' => $horaInicio->format('H:i'),
                'hora_fin'    => $horaFin->format('H:i'),
                'estado'      => 'pendiente',
            ]);
        });
    }

    /**
     * Validar que el turno esté dentro del horario del negocio
     */
    private function validarHorarioNegocio(
        int $negocioId,
        string $fecha,
        Carbon $inicio,
        Carbon $fin
    ): void {
        $diaSemana = Carbon::parse($fecha)->dayOfWeekIso; // 1=lunes

        $horario = Horario::where('id_negocio', $negocioId)
            ->where('dia', $diaSemana)
            ->first();

        if (!$horario) {
            throw new Exception('El negocio no atiende este día');
        }

        if (
            $inicio->format('H:i') < $horario->hora_apertura ||
            $fin->format('H:i') > $horario->hora_cierre
        ) {
            throw new Exception('El horario está fuera del horario de atención');
        }
    }

    /**
     * Verifica solapamiento de turnos
     */
    private function haySolapamiento(
        int $negocioId,
        string $fecha,
        string $inicio,
        string $fin
    ): bool {
        return DB::table('turnos')
            ->where('id_negocio', $negocioId)
            ->where('fecha', $fecha)
            ->where(function ($q) use ($inicio, $fin) {
                $q->whereBetween('hora_inicio', [$inicio, $fin])
                  ->orWhereBetween('hora_fin', [$inicio, $fin])
                  ->orWhere(function ($q2) use ($inicio, $fin) {
                      $q2->where('hora_inicio', '<=', $inicio)
                         ->where('hora_fin', '>=', $fin);
                  });
            })
            ->exists();
    }
}
