<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfesionistaController;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', [RegisterController::class, 'store']);

Route::middleware(['checkRole:cliente'])->group(function () {

    Route::get('/cliente', function () {
        return view('cliente.dashboard');
    });

    Route::get('/cliente/catalogo', [ClienteController::class, 'index']);
    Route::get('/cliente/contrataciones', [ClienteController::class, 'misContratos']);
});

Route::middleware(['checkRole:trabajador'])->group(function () {

    Route::get('/trabajador', function () {
        return view('trabajador.dashboard');
    });

    Route::get('/trabajador/servicios', [ProfesionistaController::class, 'serviciosAsignados']);
});

Route::middleware(['checkRole:admin'])->group(function () {

    Route::get('/admin', function () {
        return view('admin.dashboard');
    });

    Route::get('/admin/stats', [AdminController::class, 'getGlobalStats']);
    Route::get('/admin/reportes', [AdminController::class, 'downloadLogs']);
});

Route::middleware(['checkRole:ingeniero'])->group(function () {

    Route::get('/ingeniero', function () {
        return view('ingeniero.dashboard');
    });
});
