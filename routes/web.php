<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\NegocioController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/crear-superadmin', [UsuarioController::class, 'crearSuperadmin']);

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil.index');
    Route::get('/perfil/edit', [ProfileController::class, 'edit'])->name('perfil.edit');
    Route::get('/perfil/create', [ProfileController::class, 'create'])->name('perfil.create');
    Route::patch('/perfil/update', [ProfileController::class, 'update'])->name('perfil.update');
    Route::delete('/perfil/destroy', [ProfileController::class, 'destroy'])->name('perfil.destroy');
    Route::post('/perfil/store', [ProfileController::class, 'store'])->name('perfil.store');

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/cliente/index', [ClienteController::class, 'index'])->name('cliente.index');

    Route::get('/turnos/create', [TurnoController::class, 'create'])->name('turnos.create');
    Route::post('/turnos', [TurnoController::class, 'store'])->name('turnos.store');
    Route::get('/mis-turnos', [TurnoController::class, 'index'])->name('turnos.index');
    Route::post('turnos/{turno}/cancelar', [TurnoController::class, 'cancelar'])->name('turnos.cancelar');

    Route::get('/negocios', [NegocioController::class, 'index'])->name('negocios.index');
    Route::get('/negocios/create', [NegocioController::class, 'create'])->name('negocios.create');
    Route::post('/negocios', [NegocioController::class, 'store'])->name('negocios.store');
    Route::get('/negocios/{negocio}/edit', [NegocioController::class, 'edit'])->name('negocios.edit');
    Route::put('/negocios/{negocio}', [NegocioController::class, 'update'])->name('negocios.update');
    Route::delete('/negocios/{negocio}', [NegocioController::class, 'destroy'])->name('negocios.destroy');
    Route::get('/negocios/{negocio:slug}', [NegocioController::class, 'show'])->name('negocios.show');


    Route::get('/negocios/{negocio}/servicios', [ServicioController::class, 'index'])->name('negocios.servicios.index');
    Route::get('/negocios/{negocio}/servicios/create', [ServicioController::class, 'create'])->name('negocios.servicios.create');
    Route::post('/negocios/{negocio}/servicios', [ServicioController::class, 'store'])->name('negocios.servicios.store');
    Route::get('/negocios/{negocio}/servicios/{servicio}/edit', [ServicioController::class, 'edit'])->name('negocios.servicios.edit');
    Route::put('/negocios/{negocio}/servicios/{servicio}', [ServicioController::class, 'update'])->name('negocios.servicios.update');
    Route::delete('/negocios/{negocio}/servicios/{servicio}', [ServicioController::class, 'destroy'])->name('negocios.servicios.destroy');
    Route::patch('negocios/{negocio}/servicios/{servicio}/toggle', [ServicioController::class, 'toggleEstado'])->name('negocios.servicios.toggle');
    Route::get('/negocios/{negocio}/turnos', [NegocioController::class, 'turnos'])->name('negocios.negocios-turnos');


    Route::get('negocios/{negocio}/horarios', [HorarioController::class, 'edit'])->name('negocios.horarios.edit');
    Route::post('negocios/{negocio}/horarios', [HorarioController::class, 'update'])->name('negocios.horarios.update');

    Route::middleware('auth')->prefix('negocios/{negocio}/admin')->name('negocios.admin.')->group(function () {

        Route::get('/', [NegocioController::class, 'dashboard'])->name('dashboard');
        Route::get('/stats', [NegocioController::class, 'dashboardData'])->name('stats');
        Route::get('/turnos', [TurnoController::class, 'adminIndex'])->name('turnos');
        Route::get('/servicios', [ServicioController::class, 'adminIndex'])->name('servicios');
        Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados');
    });

    Route::prefix('negocios/{negocio}/admin')->name('negocios.admin.')->group(function () {
        Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados');
        Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create');
        Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');
        Route::get('/empleados/{usuario}/edit', [EmpleadoController::class, 'edit'])->name('empleados.edit');
        Route::put('/empleados/{usuario}', [EmpleadoController::class, 'update'])->name('empleados.update');
        Route::delete('/empleados/{usuario}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');
        Route::patch('/empleados/{usuario}/toggle-estado', [EmpleadoController::class, 'toggleEstado'])->name('empleados.toggle-estado');
    });

    Route::middleware(['auth', 'super_admin'])->prefix('super-admin')->name('superadmin.')->group(function () {

        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/negocios', [SuperAdminController::class, 'negocios'])->name('negocios.index');
        Route::patch('/negocios/{negocio}/toggle', [SuperAdminController::class, 'toggleNegocio'])->name('negocios.toggle');
        Route::get('/usuarios', [SuperAdminController::class, 'usuarios'])->name('usuarios.index');
        Route::get('/roles', [SuperAdminController::class, 'roles'])->name('roles.index');


        Route::get('/usuarios/{usuario}', [SuperAdminController::class, 'showUsuario'])->name('usuarios.show');
    });
});

require __DIR__ . '/auth.php';
