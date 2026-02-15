<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use App\Models\Servicio;
use App\Services\ServicioService;
use Illuminate\Http\Request;
use Exception;

class ServicioController extends Controller
{

    public function index(Negocio $negocio)
    {
        $servicios = $negocio->servicios()->paginate(10);
        return view('negocios.admin.servicios.index', compact('negocio', 'servicios'));
    }

    public function create(Negocio $negocio)
    {
        return view('negocios.admin.servicios.create', compact('negocio'));
    }

    public function store(Request $request, Negocio $negocio, ServicioService $service)
    {
        $request->validate([
            'nombre'     => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'duracion'   => 'required|integer|min:1',
            'precio'     => 'required|numeric|min:0',
            'buffer_antes'  => 'nullable|integer|min:0|max:60',
            'buffer_despues' => 'nullable|integer|min:0|max:60',
        ]);

        $datos = $request->all();
        $datos['id_negocio'] = $negocio->id;

        try {
            $service->crear($datos);
            return redirect()->route('negocios.servicios.index', $negocio)
                ->with('success', 'Servicio creado');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function edit(Negocio $negocio, Servicio $servicio)
    {
        return view('negocios.admin.servicios.edit', compact('negocio', 'servicio'));
    }

    public function update(Request $request, Negocio $negocio, Servicio $servicio, ServicioService $service)
    {
        try {
            $service->actualizar($servicio, $request->all());
            return redirect()->route('negocios.servicios.index', $negocio)
                ->with('success', 'Servicio actualizado');
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

    public function desactivar(Negocio $negocio, Servicio $servicio)
    {
        $servicio->update(['activo' => 0]);
        return redirect()->route('negocios.servicios.index', $negocio)->with('success', 'El servicio fue desactivado correctamente.');
    }

    public function toggleEstado(Negocio $negocio, Servicio $servicio)
    {
        if ($servicio->id_negocio !== $negocio->id) {
            abort(404);
        }

        $servicio->activo = !$servicio->activo;
        $servicio->save();

        return redirect()->route('negocios.servicios.index', $negocio)->with('success', 'El estado del servicio fue actualizado correctamente.');
    }

    public function adminIndex(Negocio $negocio)
    {
        abort_if(!auth()->user()->esAdmin($negocio), 403);

        $servicios = $negocio->servicios()
            ->orderBy('nombre')
            ->paginate(10);

        return view('negocios.admin.servicios.index', compact('negocio', 'servicios'));
    }
}
