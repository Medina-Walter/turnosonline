<?php

namespace App\Services;

use App\Models\Turno;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class TurnoService
{
    protected HorarioService $horarioService;

    public function __construct(HorarioService $horarioService)
    {
        $this->horarioService = $horarioService;
    }

    public function crear(array $data): Turno
    {
        return DB::transaction(function () use ($data) {

            $servicio = Servicio::findOrFail($data['id_servicio']);

            $horaInicio = Carbon::createFromFormat('H:i', $data['hora_inicio']);
            $horaFin = (clone $horaInicio)->addMinutes($servicio->duracion);

            // 👇 delegamos al HorarioService
            $this->horarioService->validarRangoHorario(
                $data['id_negocio'],
                $data['fecha'],
                $horaInicio->format('H:i'),
                $horaFin->format('H:i')
            );

            if ($this->haySolapamiento(
                $data['id_negocio'],
                $data['fecha'],
                $horaInicio->format('H:i'),
                $horaFin->format('H:i')
            )) {
                throw new Exception('El horario seleccionado no está disponible');
            }

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
