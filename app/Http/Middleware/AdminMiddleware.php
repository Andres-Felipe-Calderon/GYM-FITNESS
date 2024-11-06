<?php

// app/Http/Middleware/AdminMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario está autenticado y tiene el rol de admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Redirige a la página de inicio si no tiene acceso
        return redirect('login')->with('error', 'No tienes acceso al panel de administración.');
    }
}
