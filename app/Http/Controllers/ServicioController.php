<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Services\ServicioService;
use Illuminate\Http\Request;
use Exception;

class ServicioController extends Controller
{
    public function store(Request $request, ServicioService $service)
    {
        $request->validate([
            'id_negocio' => 'required|exists:negocios,id',
            'nombre'     => 'required|string|max:255',
            'duracion'   => 'required|integer|min:1',
            'precio'     => 'required|numeric|min:0',
        ]);

        try {
            $service->crear($request->all());
            return back()->with('success', 'Servicio creado');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function update(Request $request, Servicio $servicio, ServicioService $service)
    {
        try {
            $service->actualizar($servicio, $request->all());
            return back()->with('success', 'Servicio actualizado');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy(Servicio $servicio, ServicioService $service)
    {
        try {
            $service->eliminar($servicio);
            return back()->with('success', 'Servicio eliminado');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
