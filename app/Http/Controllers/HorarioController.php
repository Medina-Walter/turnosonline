<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function edit(Negocio $negocio)
    {
        $horarios = $negocio->horarios()->get()->keyBy('dia_semana');
        return view('horarios.edit', compact('negocio', 'horarios'));
    }

    public function update(Request $request, Negocio $negocio)
    {
        $dias = [0, 1, 2, 3, 4, 5, 6];

        foreach ($dias as $dia) {
            $hora_inicio = $request->input("horarios.$dia.hora_inicio");
            $hora_fin    = $request->input("horarios.$dia.hora_fin");

            if ($hora_inicio && $hora_fin) {
                if ($hora_inicio >= $hora_fin) {
                    return back()->withErrors("La hora de inicio debe ser anterior a la de fin para el día {$dia}.");
                }

                Horario::updateOrCreate(
                    [
                        'id_negocio' => $negocio->id,
                        'dia_semana' => $dia
                    ],
                    [
                        'hora_inicio' => $hora_inicio,
                        'hora_fin'    => $hora_fin,
                    ]
                );
            } else {
                // Elimina si no hay franja
                Horario::where('id_negocio', $negocio->id)
                    ->where('dia_semana', $dia)
                    ->delete();
            }
        }

        return back()->with('success', 'Horarios actualizados correctamente.');
    }
}
