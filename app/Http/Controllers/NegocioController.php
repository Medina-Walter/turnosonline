<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use Illuminate\Http\Request;

class NegocioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'telefono'  => 'required',
            'email'     => 'required|email',
            'direccion' => 'required|string',
        ]);

        Negocio::create([
            'id_usuario' => auth()->id(),
            'nombre'     => $request->nombre,
            'slug'       => str()->slug($request->nombre),
            'telefono'   => $request->telefono,
            'email'      => $request->email,
            'direccion'  => $request->direccion,
        ]);

        return back()->with('success', 'Negocio creado');
    }
}
