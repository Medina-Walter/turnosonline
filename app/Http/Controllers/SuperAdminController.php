<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\SuperAdminService;


class SuperAdminController extends Controller
{
    public function dashboard(
        SuperAdminService $dashboardService
    ) {
        $dias = request('dias', 7);

        $stats = $dashboardService->stats($dias);

        return view('super_admin.dashboard', $stats);
    }

    public function dashboardData(
        SuperAdminService $dashboardService
    ) {

        $dias = request('dias', 7);

        return response()->json(
            $dashboardService->stats($dias)
        );
    }

    public function negocios()
    {
        $negocios = Negocio::with('usuarios')
            ->latest()
            ->paginate(10);

        return view('super_admin.negocios.index', compact('negocios'));
    }

    public function showNegocio(Negocio $negocio)
    {
        $negocio->load([
            'usuarios',
            'horarios',
            'turnos'
        ]);

        return view('super_admin.negocios.show', compact('negocio'));
    }

    public function toggleNegocio(Negocio $negocio)
    {
        $negocio->estado = $negocio->estado === 'activo' ? 'suspendido' : 'activo';

        $negocio->save();

        return back()->with('success', 'Estado actualizado');
    }

    public function usuarios()
    {
        $usuarios = Usuario::with('negocios')
            ->latest()
            ->paginate(20);

        return view('super_admin.usuarios.index', compact('usuarios'));
    }

    public function edit(Usuario $usuario)
    {
        return view('super_admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('superadmin.usuarios.show', $usuario)->with('success', 'Usuario actualizado correctamente');
    }

    public function roles()
    {
        $roles = Rol::all();

        return view('super_admin.roles.index', compact('roles'));
    }

    public function showUsuario(Usuario $usuario)
    {
        $usuario->load('negocios');

        $roles = Rol::all();

        $negociosDisponibles = Negocio::whereNotIn(
            'id',
            $usuario->negocios->pluck('id')
        )->get();

        return view('super_admin.usuarios.show', compact( 'usuario', 'roles', 'negociosDisponibles'
        ));
    }


    public function toggleUsuario(Usuario $usuario)
    {
        $usuario->estado = $usuario->estado === 'activo' ? 'bloqueado' : 'activo';

        $usuario->save();

        return back()->with('success', 'Estado del usuario actualizado');
    }

    public function cambiarRol(Request $request, Usuario $usuario, Negocio $negocio)
    {
        $request->validate([
            'id_rol' => 'required|exists:roles,id',
        ]);

        $usuario->negocios()->updateExistingPivot(
            $negocio->id,
            ['id_rol' => $request->id_rol]
        );

        return back()->with('success', 'Rol actualizado');
    }

    public function quitarNegocio(Usuario $usuario, Negocio $negocio)
    {
        $usuario->negocios()->detach($negocio->id);

        return back()->with('success', 'Usuario quitado del negocio');
    }

    public function asignarNegocio(Request $request, Usuario $usuario)
    {
        $request->validate([
            'id_negocio' => 'required|exists:negocios,id',
            'id_rol' => 'required|exists:roles,id',
        ]);

        $usuario->negocios()->attach(
            $request->id_negocio,
            ['id_rol' => $request->id_rol]
        );

        return back()->with('success', 'Usuario asignado al negocio');
    }

    public function simularUsuario(Usuario $usuario)
    {
        session(['id_simularusuario' => auth()->id(),]);

        Auth::login($usuario);

        return redirect('/')->with('success', 'Ahora estás actuando como este usuario');
    }

    public function updateUsuario(Request $request, Usuario $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'telefono' => 'nullable|string|max:30',
        ]);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
        ]);

        return redirect()->route('superadmin.usuarios.show', $usuario)->with('success', 'Usuario actualizado correctamente');
    }
}
