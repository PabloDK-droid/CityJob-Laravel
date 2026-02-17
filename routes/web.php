<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfesionistaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EncargadoController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\FacturaController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/ayuda', function () { return view('ayuda'); })->name('ayuda');

// Autenticación
Route::get('/register', function () {
    return view('auth.register');
})->name('register.form');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== RUTAS PARA CLIENTES =====
Route::group(['middleware' => 'role:cliente', 'prefix' => 'cliente', 'as' => 'cliente.'], function () {
    Route::get('/', [ClienteController::class, 'dashboard'])->name('dashboard');
    Route::get('/catalogo', [ClienteController::class, 'catalogoServicios'])->name('catalogo');
    Route::get('/servicio/{id}/profesionistas', [ClienteController::class, 'profesionistasServicio'])->name('profesionistas');
    Route::post('/contratar', [ClienteController::class, 'contratar'])->name('contratar');
    Route::get('/mis-contrataciones', [ClienteController::class, 'misContrataciones'])->name('misContrataciones');
    Route::get('/editar-perfil', [ClienteController::class, 'editarPerfil'])->name('editarPerfil');
    Route::post('/actualizar-perfil', [ClienteController::class, 'actualizarPerfil'])->name('actualizarPerfil');
    //Agregados
    Route::get('/calificar-servicio/{id}', [CalificacionController::class, 'create'])->name('calificarServicio');
    Route::post('/calificar-servicio', [CalificacionController::class, 'store'])->name('guardarCalificacion');
    Route::get('/descargar-factura/{id}', [FacturaController::class, 'descargarPDF'])->name('descargarFactura');
});

// ===== RUTAS PARA TRABAJADORES/PROFESIONISTAS =====
Route::group(['middleware' => 'role:trabajador', 'prefix' => 'trabajador', 'as' => 'trabajador.'], function () {
    Route::get('/', [ProfesionistaController::class, 'dashboard'])->name('dashboard');
    Route::get('/servicios-asignados', [ProfesionistaController::class, 'serviciosAsignados'])->name('serviciosAsignados');
    Route::get('/servicio/{id}', [ProfesionistaController::class, 'detalleServicio'])->name('detalleServicio');
    Route::get('/editar-perfil', [ProfesionistaController::class, 'editarPerfil'])->name('editarPerfil');
    Route::post('/actualizar-perfil', [ProfesionistaController::class, 'actualizarPerfil'])->name('actualizarPerfil');
    //Agregados
    Route::post('/completar-servicio/{id}', [ProfesionistaController::class, 'completarServicio'])->name('completarServicio');
    Route::get('/peticiones-pendientes', [ProfesionistaController::class, 'peticionesPendientes'])->name('peticionesPendientes');
    Route::post('/aceptar-trabajo/{id}', [ProfesionistaController::class, 'aceptarTrabajo'])->name('aceptarTrabajo');
    Route::post('/rechazar-trabajo/{id}', [ProfesionistaController::class, 'rechazarTrabajo'])->name('rechazarTrabajo');
});

// ===== RUTAS PARA ADMINISTRADORES =====
Route::group(['middleware' => 'role:admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestión de usuarios
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    Route::post('/usuarios/cambiar-rol', [AdminController::class, 'cambiarRol'])->name('cambiarRol');
    Route::post('/usuarios/eliminar', [AdminController::class, 'eliminarUsuario'])->name('eliminarUsuario');
    Route::post('/usuarios/registrar-trabajador', [AdminController::class, 'registerWorker'])->name('registerWorker');
    
    // Gestión de servicios
    Route::get('/servicios', [AdminController::class, 'servicios'])->name('servicios');
    Route::post('/servicios/crear', [AdminController::class, 'crearServicio'])->name('crearServicio');
    Route::post('/servicios/{id}/actualizar', [AdminController::class, 'actualizarServicio'])->name('actualizarServicio');
    Route::post('/servicios/{id}/eliminar', [AdminController::class, 'eliminarServicio'])->name('eliminarServicio');
    
    // Contrataciones y reportes
    Route::get('/contrataciones', [AdminController::class, 'contrataciones'])->name('contrataciones');
    Route::get('/estadisticas', [AdminController::class, 'getGlobalStats'])->name('estadisticas');
    Route::get('/descargar-logs', [AdminController::class, 'downloadLogs'])->name('downloadLogs');
});

// ===== RUTAS PARA INGENIEROS/ENCARGADOS =====
Route::group(['middleware' => 'role:ingeniero', 'prefix' => 'ingeniero', 'as' => 'ingeniero.'], function () {
    Route::get('/', [EncargadoController::class, 'index'])->name('dashboard');
    Route::get('/contratacion/{id}', [EncargadoController::class, 'show'])->name('detalleContratacion');
    Route::post('/contratacion/{id}/cancelar', [EncargadoController::class, 'cancelar'])->name('cancelar');
    Route::get('/pagos', [EncargadoController::class, 'serviciosPorPago'])->name('pagos');
    Route::get('/estadisticas', [EncargadoController::class, 'estadisticas'])->name('estadisticas');
});
