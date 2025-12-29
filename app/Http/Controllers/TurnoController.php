<?php

namespace App\Http\Controllers;

use App\Services\TurnoService;
use Illuminate\Http\Request;
use Exception;

class TurnoController extends Controller
{
    public function store(Request $request, TurnoService $service)
    {
        $request->validate([
            'id_negocio'  => 'required|exists:negocios,id',
            'id_cliente'  => 'required|exists:clientes,id',
            'id_servicio' => 'required|exists:servicios,id',
            'fecha'       => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
        ]);

        try {
            $service->crear($request->all());

            return back()->with('success', 'Turno creado correctamente');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
