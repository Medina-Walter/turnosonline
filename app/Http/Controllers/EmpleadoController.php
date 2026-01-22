<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use App\Models\Usuario;
use App\Services\EmpleadoService;
use Illuminate\Http\Request;
use App\Models\Rol;

class EmpleadoController extends Controller
{
    /**
     * Listar empleados del negocio
     */
    public function index(Negocio $negocio)
    {
        $roles = Rol::pluck('nombre', 'id'); // [id => nombre]

        $empleados = $negocio->usuarios()->get();

        return view('negocios.admin.empleados.index', compact(
            'negocio',
            'empleados',
            'roles'
        ));
    }


    /**
     * Formulario crear empleado
     */
    public function create(Negocio $negocio)
    {
        abort_if(!auth()->user()->esAdmin($negocio), 403);

        return view(
            'negocios.admin.empleados.create',
            compact('negocio')
        );
    }

    /**
     * Guardar empleado
     */
    public function store(
        Request $request,
        Negocio $negocio,
        EmpleadoService $empleadoService
    ) {
        abort_if(!auth()->user()->esAdmin($negocio), 403);

        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $empleadoService->crearEmpleadoParaNegocio(
            $negocio,
            $request->only('nombre', 'apellido', 'email', 'password')
        );

        return redirect()
            ->route('negocios.admin.empleados', $negocio)
            ->with('success', 'Empleado agregado correctamente');
    }

    public function edit(Negocio $negocio, Usuario $usuario)
    {
        abort_if(!auth()->user()->esAdmin($negocio), 403);

        // Verificar que el usuario pertenece al negocio
        abort_if(
            ! $negocio->usuarios()->where('usuarios.id', $usuario->id)->exists(),
            404
        );

        $roles = Rol::pluck('nombre', 'id');

        return view('negocios.admin.empleados.edit', compact(
            'negocio',
            'usuario',
            'roles'
        ));
    }

    public function update(
        Request $request,
        Negocio $negocio,
        Usuario $usuario
    ) {
        abort_if(!auth()->user()->esAdmin($negocio), 403);

        $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email'    => 'required|email|unique:usuarios,email,' . $usuario->id,
            'id_rol'   => 'required|exists:roles,id',
        ]);

        // Actualizar datos del usuario
        $usuario->update([
            'nombre'   => $request->nombre,
            'apellido' => $request->apellido,
            'email'    => $request->email,
        ]);

        // Actualizar rol en el negocio
        $negocio->usuarios()->updateExistingPivot(
            $usuario->id,
            ['id_rol' => $request->id_rol]
        );

        return redirect()
            ->route('negocios.admin.empleados', $negocio)
            ->with('success', 'Empleado actualizado correctamente');
    }

    /**
     * Quitar empleado del negocio
     */
    public function destroy(Negocio $negocio, Usuario $usuario)
    {
        abort_if(!auth()->user()->esAdmin($negocio), 403);

        $negocio->usuarios()->detach($usuario->id);

        return back()->with('success', 'Empleado eliminado correctamente');
    }

    public function toggleEstado(Negocio $negocio, Usuario $usuario)
    {
        abort_if(!auth()->user()->esAdmin($negocio), 403);

        // Verificar que el usuario pertenece al negocio
        abort_if(
            ! $negocio->usuarios()->where('usuarios.id', $usuario->id)->exists(),
            404
        );

        $usuario->estado = $usuario->estado === 'activo'
            ? 'inactivo'
            : 'activo';

        $usuario->save();

        return back()->with(
            'success',
            'Estado del empleado actualizado correctamente'
        );
    }
}
