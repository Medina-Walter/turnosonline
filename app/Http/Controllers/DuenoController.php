<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DuenoController extends Controller
{
    public function misTurnos()
    {
        // Si cada usuario puede tener más de un negocio:
        $negocios = auth()->user()->negocios; // relación hasMany en User

        // juntar todos los turnos de los negocios de este dueño
        $turnos = \App\Models\Turno::with(['usuario', 'servicio', 'negocio'])
            ->whereIn('id_negocio', $negocios->pluck('id'))
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();

        return view('dueno.turnos', compact('turnos')); // crea esta vista
    }
}
