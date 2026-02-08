<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/register', [RegisterController::class, 'store']);

// Solo para Clientes
Route::group(['middleware' => 'role:cliente'], function () {
    Route::get('/cliente', function () { return view('cliente'); });
});

// Solo para Trabajadores
Route::group(['middleware' => 'role:trabajador'], function () {
    Route::get('/trabajador', function () { return view('trabajador'); });
});

// Solo para Administradores
Route::group(['middleware' => 'role:admin'], function () {
    Route::get('/admin', function () { return view('admin'); });
});

// Solo para Ingenieros/Encargados
Route::group(['middleware' => 'role:ingeniero'], function () {
    Route::get('/ingeniero', function () { return view('ingeniero'); });
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');