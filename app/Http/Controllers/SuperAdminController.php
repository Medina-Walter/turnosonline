<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    /**
     * Dashboard principal
     */
    public function dashboard()
    {
        $stats = [
            'negocios' => Negocio::count(),
            'usuarios' => Usuario::count(),

            'negocios_activos' =>
            Negocio::where('estado', 'activo')->count(),

            'negocios_suspendidos' =>
            Negocio::where('estado', 'suspendido')->count(),
        ];

        return view('super_admin.dashboard', compact('stats'));
    }

    /**
     * Listado global de negocios
     */
    public function negocios()
    {
        $negocios = Negocio::latest()->paginate(20);

        return view('super_admin.negocios.index', compact('negocios'));
    }

    /**
     * Activar / suspender negocio
     */
    public function toggleNegocio(Negocio $negocio)
    {
        $negocio->estado =
            $negocio->estado === 'activo'
            ? 'suspendido'
            : 'activo';

        $negocio->save();

        return back()->with('success', 'Estado actualizado');
    }

    /**
     * Usuarios globales
     */
    public function usuarios()
    {
        $usuarios = Usuario::with('negocios')
            ->latest()
            ->paginate(20);

        return view('super_admin.usuarios.index', compact('usuarios'));
    }


    /**
     * Roles
     */
    public function roles()
    {
        $roles = Rol::all();

        return view('super_admin.roles.index', compact('roles'));
    }

    public function showUsuario(Usuario $usuario)
    {
        $usuario->load([
            'negocios' => function ($q) {
                $q->withPivot('id_rol');
            },
        ]);

        return view('super_admin.usuarios.show', compact('usuario'));
    }
}
