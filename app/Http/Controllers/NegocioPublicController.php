<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Negocio;

class NegocioPublicController extends Controller
{
    public function show(string $slug)
    {
        $negocio = Negocio::where('slug', $slug)
            ->where('estado', 'activo')
            ->firstOrFail();


        return view('public.negocios.show', compact('negocio'));
    }
}
