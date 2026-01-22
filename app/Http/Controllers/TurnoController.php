<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use App\Models\Servicio;
use App\Models\Turno;
use App\Services\TurnoService;
use Illuminate\Http\Request;
use Exception;

class TurnoController extends Controller
{
    // En el método del controlador:
    public function index()
    {
        $turnos = Turno::with(['negocio', 'servicio'])
            ->where('id_usuario', auth()->id())
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();
        return view('cliente.index', compact('turnos'));
    }

    /**
     * Muestra el formulario para crear un nuevo turno.
     */
    public function create()
    {
        $user = auth()->user();
        if (empty($user->nombre) || empty($user->apellido)) {
            return redirect()
                ->route('perfil.create')
                ->with('status', 'perfil-incomplete');
        }

        return view('turnos.create', [
            'negocios'  => Negocio::all(),
            'servicios' => Servicio::all(),
        ]);
    }

    /**
     * Guarda un turno nuevo.
     */
    public function store(Request $request, TurnoService $service)
    {
        $user = auth()->user();
        if (empty($user->nombre) || empty($user->apellido)) {
            return redirect()
                ->route('perfil.create')
                ->with('status', 'perfil-incomplete');
        }

        $request->validate([
            'id_negocio'  => 'required|exists:negocios,id',
            'id_servicio' => 'required|exists:servicios,id',
            'fecha'       => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'nullable|date_format:H:i',
        ]);

        try {
            $data = $request->all();
            $data['id_usuario'] = auth()->id();

            if (empty($data['hora_fin'])) {
                $servicio = Servicio::findOrFail($data['id_servicio']);
                $inicio = \Carbon\Carbon::parse($data['hora_inicio']);
                $fin = $inicio->copy()->addMinutes($servicio->duracion);
                $data['hora_fin'] = $fin->format('H:i');
            }

            $data['estado'] = $data['estado'] ?? 'pendiente';
            $service->crear($data);

            return redirect()->route('turnos.index')->with('success', 'Turno Asignado.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function cancelar(Turno $turno)
    {
        if ($turno->id_usuario !== auth()->id()) abort(403);
        $turno->estado = 'cancelado';
        $turno->save();
        return back()->with('success', 'Turno cancelado.');
    }

    public function adminIndex(Negocio $negocio)
    {
        abort_if(!auth()->user()->esAdmin($negocio), 403);

        $turnos = $negocio->turnos()
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();

        return view('negocios.admin.turnos.index', compact('negocio', 'turnos'));
    }
}
