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
use App\Http\Controllers\SuscripcionController;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PlanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaPublicController;
use App\Http\Controllers\NegocioPublicController;
use App\Http\Controllers\WebhookController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/crear-superadmin', [UsuarioController::class, 'crearSuperadmin']);



// =======================================================
// 🔐 AUTENTICADOS
// =======================================================

Route::middleware('auth')->group(function () {

    // ---------------- PERFIL ----------------
    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil.index');
    Route::get('/perfil/edit', [ProfileController::class, 'edit'])->name('perfil.edit');
    Route::get('/perfil/create', [ProfileController::class, 'create'])->name('perfil.create');
    Route::patch('/perfil/update', [ProfileController::class, 'update'])->name('perfil.update');
    Route::delete('/perfil/destroy', [ProfileController::class, 'destroy'])->name('perfil.destroy');
    Route::post('/perfil/store', [ProfileController::class, 'store'])->name('perfil.store');


    // ---------------- DASHBOARD ----------------
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/cliente/index', [ClienteController::class, 'index'])->name('cliente.index');

    // ---------------- TURNOS ----------------


    Route::middleware(['auth', 'profile.completed'])->group(function () {

        Route::get('/turnos/create', [TurnoController::class, 'create'])->name('turnos.create');
        Route::post('/turnos', [TurnoController::class, 'store'])->name('turnos.store');

        Route::get(
            '/negocios/{negocio}/disponibilidad/{fecha}',
            [TurnoController::class, 'disponibilidad']
        )->name('negocios.disponibilidad');
    });

    Route::get('/mis-turnos', [TurnoController::class, 'index'])->name('turnos.index');
    Route::post('turnos/{turno}/cancelar', [TurnoController::class, 'cancelar'])->name('turnos.cancelar');



    // ---------------- NEGOCIOS ----------------
    Route::get('/negocios', [NegocioController::class, 'index'])->name('negocios.index');

    Route::get('/negocios/create', [NegocioController::class, 'create'])->name('negocios.create');

    Route::post('/negocios', [NegocioController::class, 'store'])->name('negocios.store');

    Route::get('/negocios/{negocio}/edit', [NegocioController::class, 'edit'])->name('negocios.edit');
    Route::put('/negocios/{negocio}', [NegocioController::class, 'update'])->name('negocios.update');
    Route::delete('/negocios/{negocio}', [NegocioController::class, 'destroy'])->name('negocios.destroy');
    Route::get('/negocios/{negocio:slug}', [NegocioController::class, 'show'])->name('negocios.show');


    // ---------------- SERVICIOS ----------------
    Route::get('/negocios/{negocio}/servicios', [ServicioController::class, 'index'])->name('negocios.servicios.index');
    Route::get('/negocios/{negocio}/servicios/create', [ServicioController::class, 'create'])->name('negocios.servicios.create');
    Route::post('/negocios/{negocio}/servicios', [ServicioController::class, 'store'])->name('negocios.servicios.store');
    Route::get('/negocios/{negocio}/servicios/{servicio}/edit', [ServicioController::class, 'edit'])->name('negocios.servicios.edit');
    Route::put('/negocios/{negocio}/servicios/{servicio}', [ServicioController::class, 'update'])->name('negocios.servicios.update');
    Route::delete('/negocios/{negocio}/servicios/{servicio}', [ServicioController::class, 'destroy'])->name('negocios.servicios.destroy');
    Route::patch('negocios/{negocio}/servicios/{servicio}/toggle', [ServicioController::class, 'toggleEstado'])->name('negocios.servicios.toggle');


    // ---------------- HORARIOS ----------------
    Route::get('negocios/{negocio}/horarios', [HorarioController::class, 'edit'])->name('negocios.horarios.edit');
    Route::post('negocios/{negocio}/horarios', [HorarioController::class, 'update'])->name('negocios.horarios.update');


    // ---------------- ADMIN NEGOCIO ----------------
    Route::prefix('negocios/{negocio}/admin')
        ->name('negocios.admin.')
        ->middleware('auth')
        ->group(function () {

            Route::get('/', [NegocioController::class, 'dashboard'])->name('dashboard');
            Route::get('/stats', [NegocioController::class, 'dashboardData'])->name('stats');
            Route::get('/turnos', [TurnoController::class, 'adminIndex'])->name('turnos');
            Route::get('/servicios', [ServicioController::class, 'adminIndex'])->name('servicios');
            Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados');

            // ⛔ crear empleados → PRO/AVANZADO
            Route::get('/empleados/create', [EmpleadoController::class, 'create'])
                ->middleware('plan:pro,avanzado')
                ->name('empleados.create');

            Route::post('/empleados', [EmpleadoController::class, 'store'])
                ->middleware('plan:pro,avanzado')
                ->name('empleados.store');
        });


    // =======================================================
    // 💳 SUSCRIPCIONES
    // =======================================================

    Route::get('/suscripcion', [SuscripcionController::class, 'index'])
        ->name('suscripcion.index');

    Route::post('/suscripcion/cambiar-plan', [SuscripcionController::class, 'cambiarPlan'])
        ->name('suscripcion.cambiar');

    Route::get('/suscripcion/success', function () {
        return "Pago exitoso";
    })->name('suscripciones.success');

    Route::get('/suscripcion/failure', function () {
        return "Pago fallido";})->name('suscripciones.failure');


    // =======================================================
    // 👑 SUPER ADMIN
    // =======================================================

    Route::middleware('super_admin')
        ->prefix('super-admin')
        ->name('superadmin.')
        ->group(function () {

            Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
            Route::get('/dashboard/data', [SuperAdminController::class, 'dashboardData'])->name('dashboard.data');

            Route::get('/negocios', [SuperAdminController::class, 'negocios'])->name('negocios.index');
            Route::patch('/negocios/{negocio}/toggle', [SuperAdminController::class, 'toggleNegocio'])->name('negocios.toggle');
            Route::get('/negocios/{negocio}', [SuperAdminController::class, 'showNegocio'])->name('negocios.show');

            Route::get('/usuarios', [SuperAdminController::class, 'usuarios'])->name('usuarios.index');
            Route::get('/usuarios/{usuario}', [SuperAdminController::class, 'showUsuario'])->name('usuarios.show');
            Route::patch('/usuarios/{usuario}/toggle', [SuperAdminController::class, 'toggleUsuario'])->name('usuarios.toggle');
        });


    // ---------------- CRUD PLANES ----------------
    Route::middleware('super_admin')
        ->prefix('super-admin/planes')
        ->name('superadmin.planes.')
        ->group(function () {

            Route::get('/', [PlanController::class, 'index'])->name('index');
            Route::get('/create', [PlanController::class, 'create'])->name('create');
            Route::post('/', [PlanController::class, 'store'])->name('store');
            Route::get('/{plan}/edit', [PlanController::class, 'edit'])->name('edit');
            Route::put('/{plan}', [PlanController::class, 'update'])->name('update');
            Route::delete('/{plan}', [PlanController::class, 'destroy'])->name('destroy');
        });
});

Route::get('/negocios/{slug}', [NegocioPublicController::class, 'show'])->name('negocios.public.show');

Route::get('/negocios/{slug}/reservar', [ReservaPublicController::class, 'create'])->name('reservas.public.create');
Route::post('/negocios/{slug}/reservar', [ReservaPublicController::class, 'store'])->name('reservas.public.store');

Route::post('/webhook/mercadopago', [WebhookController::class, 'mercadopago']);

require __DIR__ . '/auth.php';
