<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Turno;

class ClienteController extends Controller
{
    public function index()
    {
        $turnos = Turno::with(['negocio', 'servicio'])
            ->where('id_usuario', auth()->id())
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->paginate(10);

        return view('cliente.index', compact('turnos'));
    }
}
