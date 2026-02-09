<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token requerido'], 401);
        }

        $registro = DB::table('tokens')
            ->where('token', hash('sha256', $token))
            ->first();

        if (!$registro) {
            return response()->json(['error' => 'Token inválido'], 401);
        }

        $request->merge([
            'usuario_id' => $registro->usuario_id,
            'tipo_usuario' => $registro->tipo_usuario
        ]);

        return $next($request);
    }
}
