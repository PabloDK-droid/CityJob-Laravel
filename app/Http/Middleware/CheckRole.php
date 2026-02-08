<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next, string $role): Response
{
    if (!session()->has('role')) {
        return redirect('/login')->withErrors(['mensaje' => 'Debes iniciar sesión para acceder.']);
    }
    if (session('role') !== $role) {
        return redirect('/' . session('role'))->withErrors(['mensaje' => 'No tienes permiso para esta área.']);
    }

    return $next($request);
}
}
