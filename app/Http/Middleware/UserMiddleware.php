<?php
// app/Http/Middleware/UserMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Si es un usuario admin, redirige al dashboard admin si intenta acceder al dashboard de usuario
            if (Auth::user()->role === 'admin') {
                return redirect()->route('administrador.index');
            }

            // Si es un usuario normal (role === 'user'), permite el acceso a su dashboard
            if (Auth::user()->role === 'user') {
                return $next($request);
            }

            // Redirige a la página de inicio si no tiene acceso
            return redirect()->route('login')->with('error', 'Tu cuenta ha sido deshabilitada. Por favor, contacta a la administración.');
        }

        // Redirige a la página de inicio de sesión si no está autenticado
        return redirect()->route('login')->with('error', 'Por favor, inicia sesión para continuar.');
    }
}
