<?php

namespace App\Services;

use App\Models\Servicio;
use Exception;

class ServicioService
{
    /**
     * Crear un servicio
     */
    public function crear(array $data): Servicio
    {
        if ($data['duracion'] <= 0) {
            throw new Exception('La duración del servicio debe ser mayor a 0');
        }

        if ($data['precio'] < 0) {
            throw new Exception('El precio no puede ser negativo');
        }

        return Servicio::create([
            'id_negocio' => $data['id_negocio'],
            'nombre'     => $data['nombre'],
            'duracion'   => $data['duracion'],
            'precio'     => $data['precio'],
        ]);
    }

    /**
     * Actualizar un servicio
     */
    public function actualizar(Servicio $servicio, array $data): Servicio
    {
        if (isset($data['duracion']) && $data['duracion'] <= 0) {
            throw new Exception('La duración debe ser mayor a 0');
        }

        if (isset($data['precio']) && $data['precio'] < 0) {
            throw new Exception('El precio no puede ser negativo');
        }

        $servicio->update($data);

        return $servicio;
    }

    /**
     * Eliminar un servicio
     */
    public function eliminar(Servicio $servicio): void
    {
        if ($servicio->turnos()->exists()) {
            throw new Exception('No se puede eliminar un servicio con turnos asociados');
        }

        $servicio->delete();
    }

    /**
     * Obtener servicios de un negocio
     */
    public function listarPorNegocio(int $idNegocio)
    {
        return Servicio::where('id_negocio', $idNegocio)->get();
    }
}
