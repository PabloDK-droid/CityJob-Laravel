<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth.token')->group(function () {
    Route::get('/perfil', function (Request $request) {
        return response()->json([
            'usuario_id' => $request->usuario_id,
            'tipo_usuario' => $request->tipo_usuario
        ]);
    });
});
