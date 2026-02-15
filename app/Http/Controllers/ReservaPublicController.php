<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Negocio;
use App\Models\Turno;
use Illuminate\Http\Request;

class ReservaPublicController extends Controller
{
    public function create(string $slug)
    {
        $negocio = Negocio::where('slug', $slug)
            ->where('estado', 'activo')
            ->with('servicios')
            ->firstOrFail();

        // 👉 Si NO está logueado
        if (!auth()->check()) {
            return redirect()
                ->route('register')
                ->with('redirect_to', url()->current());
        }

        return view('public.reservas.create', compact('negocio'));
    }


    public function store(Request $request, string $slug)
    {
        $negocio = Negocio::where('slug', $slug)
            ->where('estado', 'activo')
            ->firstOrFail();

        // 👉 Si no está logueado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'servicio_id' => 'required|exists:servicios,id',
            'fecha'       => 'required|date',
            'hora'        => 'required|date_format:H:i',
        ]);

        Turno::create([
            'id_negocio'   => $negocio->id,
            'id_usuario'   => $user->id,
            'id_servicio'  => $request->servicio_id,
            'fecha'        => $request->fecha,
            'hora_inicio'  => $request->hora,
            'estado'       => 'pendiente',
        ]);

        return redirect()
            ->route('negocios.public.show', $negocio->slug)
            ->with('success', 'Turno reservado correctamente');
    }
}
