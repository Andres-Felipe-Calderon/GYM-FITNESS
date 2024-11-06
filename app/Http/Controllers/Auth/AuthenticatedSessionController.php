<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Verificar si el usuario está habilitado
        if (!$user->is_active) {
            Auth::logout();
            return redirect('/login')->with('error', 'Tu cuenta está inhabilitada.');
        }
        

        // Verificar el rol del usuario y redirigir
        if ($user->role === 'admin') {
            return redirect()->route('administrador.index'); // Cambia esto a la ruta del panel de administración
        }

        // Redirigir a la ruta de dashboard para usuarios regulares
        return redirect()->route('dashboard'); // Cambia esto a la ruta del dashboard para usuarios
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login');
    }
}
