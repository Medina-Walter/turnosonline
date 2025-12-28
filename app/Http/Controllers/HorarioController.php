<?php

namespace App\Http\Controllers;

use App\Services\HorarioService;
use Illuminate\Http\Request;
use Exception;

class HorarioController extends Controller
{
    public function store(Request $request, HorarioService $service)
    {
        $request->validate([
            'id_negocio'    => 'required|exists:negocios,id',
            'dia'           => 'required|integer|min:1|max:7',
            'hora_apertura' => 'required|date_format:H:i',
            'hora_cierre'   => 'required|date_format:H:i',
        ]);

        try {
            $service->guardarHorario(
                $request->id_negocio,
                $request->dia,
                $request->hora_apertura,
                $request->hora_cierre
            );

            return back()->with('success', 'Horario guardado');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
