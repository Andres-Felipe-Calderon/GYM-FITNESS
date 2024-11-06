<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->is_active) { // Suponiendo que 'is_active' es el campo para el estado del usuario
            Auth::logout();

            return redirect()->route('login')->with('error', 'Tu cuenta ha sido deshabilitada. Por favor, contacta a la administración.');
        }

        return $next($request);
    }
}
