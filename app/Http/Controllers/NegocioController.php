<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use App\Models\Horario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NegocioController extends Controller
{
    public function index()
    {
        $negocios = auth()->user()
            ->negocios()
            ->with('horarios')
            ->latest()
            ->get();

        return view('negocios.index', compact('negocios'));
    }


    public function create()
    {
        return view('negocios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'telefono'  => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'rubro'     => 'required|string|max:100',
            'horarios'  => 'required|array',
        ]);

        $erroresHorario = [];

        foreach ($request->horarios as $dia => $franjas) {
            foreach ($franjas as $index => $franja) {
                $inicio = $franja['hora_inicio'] ?? null;
                $fin    = $franja['hora_fin'] ?? null;

                if ($inicio && $fin) {
                    if ($inicio === $fin) {
                        $erroresHorario[] = "En {$this->nombreDia($dia)} (franja " . ($index + 1) . "): la hora no puede ser igual.";
                    }
                    if ($inicio > $fin) {
                        $erroresHorario[] = "En {$this->nombreDia($dia)} (franja " . ($index + 1) . "): la hora inicio debe ser menor.";
                    }
                }
            }
        }

        if ($erroresHorario) {
            return back()->withInput()->withErrors([
                'horarios' => implode(' ', $erroresHorario),
            ]);
        }

        $negocio = Negocio::create([
            'id_usuario' => auth()->id(),
            'nombre'    => $request->nombre,
            'slug'      => str()->slug($request->nombre),
            'telefono'  => $request->telefono,
            'direccion' => $request->direccion,
            'rubro'     => $request->rubro,
        ]);

        $rolAdmin = Rol::where('nombre', 'admin')->first();

        $negocio->usuarios()->attach(auth()->id(), [
            'id_rol' => $rolAdmin->id,
        ]);

        foreach ($request->horarios as $dia => $franjas) {
            foreach ($franjas as $franja) {
                if (!empty($franja['hora_inicio']) && !empty($franja['hora_fin'])) {
                    $negocio->horarios()->create([
                        'dia_semana'  => $dia,
                        'hora_inicio' => $franja['hora_inicio'],
                        'hora_fin'    => $franja['hora_fin'],
                    ]);
                }
            }
        }

        return redirect()->route('negocios.servicios.create', $negocio)->with('success', 'Negocio creado. Ahora agregá los servicios.');
    }

    public function edit(Negocio $negocio)
    {
        abort_if(!auth()->user()->esAdmin($negocio), 403);

        $horariosRaw = $negocio->horarios()
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get();

        $horarios = [];
        foreach ($horariosRaw as $h) {
            $horarios[$h->dia_semana][] = [
                'hora_inicio' => $h->hora_inicio,
                'hora_fin'    => $h->hora_fin,
            ];
        }

        return view('negocios.edit', compact('negocio', 'horarios'));
    }

    public function update(Request $request, Negocio $negocio)
    {
        abort_if(!auth()->user()->esAdmin($negocio), 403);

        $request->validate([
            'nombre'    => 'required|string|max:255',
            'rubro'     => 'required|string|max:255',
            'telefono'  => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'horarios'  => 'required|array',
        ]);

        $negocio->update([
            'nombre'    => $request->nombre,
            'rubro'     => $request->rubro,
            'telefono'  => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        $negocio->horarios()->delete();

        foreach ($request->horarios as $dia => $franjas) {
            foreach ($franjas as $franja) {
                if (!empty($franja['hora_inicio']) && !empty($franja['hora_fin'])) {
                    Horario::create([
                        'id_negocio'  => $negocio->id,
                        'dia_semana'  => $dia,
                        'hora_inicio' => $franja['hora_inicio'],
                        'hora_fin'    => $franja['hora_fin'],
                    ]);
                }
            }
        }

        return redirect()->route('negocios.index')->with('success', 'Negocio actualizado correctamente.');
    }

    public function destroy(Negocio $negocio)
    {
        abort_if(!auth()->user()->esAdmin($negocio), 403);

        $negocio->delete();

        return redirect()->route('negocios.index')->with('success', 'Negocio eliminado.');
    }

    public function turnos($id)
    {
        $negocio = Negocio::with(['turnos.usuario', 'turnos.servicio'])->findOrFail($id);

        abort_if(!auth()->user()->esAdmin($negocio), 403);

        $turnos = $negocio->turnos()
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();

        return view('negocios.turnos', compact('negocio', 'turnos'));
    }

    private function nombreDia($dia)
    {
        return [
            0 => 'domingo',
            1 => 'lunes',
            2 => 'martes',
            3 => 'miércoles',
            4 => 'jueves',
            5 => 'viernes',
            6 => 'sábado',
        ][$dia] ?? $dia;
    }

    public function show(Negocio $negocio)
    {
        $turnos = [];

        if (auth()->check()) {
            $turnos = auth()->user()
                ->turnos()
                ->where('negocio_id', $negocio->id)
                ->orderBy('fecha')
                ->get();
        }

        return view('negocios.public.show', compact('negocio', 'turnos'));
    }

    public function dashboard(Negocio $negocio)
    {
        abort_if(!auth()->user()->esAdmin($negocio), 403);

        $hoy = Carbon::today();

        $turnosHoy = $negocio->turnos()
            ->whereDate('fecha', $hoy)
            ->count();

        $empleadosCount = $negocio->usuarios()
            ->wherePivotIn('id_rol', [2, 3]) // admin + empleado
            ->count();

        $serviciosCount = $negocio->servicios()
            ->where('activo', true)
            ->count();

        return view('negocios.admin.dashboard', compact(
            'negocio',
            'turnosHoy',
            'empleadosCount',
            'serviciosCount'
        ));
    }
}
