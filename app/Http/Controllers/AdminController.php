<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Importa el modelo User

class AdminController extends Controller
{
    // Método principal para la vista de administración
    public function index()
    {
        // Redirigir a la ruta del dashboard
        return $this->dashboardadmin();
    }

    // Método para obtener estadísticas de usuarios
    public function dashboardadmin()
{
    // Llama a dd() para verificar si el método se invoca


    // Verifica si el usuario está autenticado
    if (!Auth::check()) {
        // Llama a dd() antes de redirigir si el usuario no está autenticado
      

        return redirect()->route('login')->with('error', 'Necesitas iniciar sesión.');
    }

    // Verifica si el usuario autenticado tiene el rol de admin
    if (Auth::user()->role === 'admin') {
       

        // Obtiene las estadísticas de usuarios
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', 1)->count();
        $inactiveUsers = User::where('is_active', 0)->count();

        // Retorna la vista con los datos
        return view('administrador.index')->with(compact('totalUsers', 'activeUsers', 'inactiveUsers'));
    }

    // Si no tiene acceso, redirige a la página de inicio de sesión
    // Llama a dd() aquí también para verificar que esta parte se ejecute
    

    return redirect()->route('login')->with('error', 'No tienes acceso al panel de administración.');
}

    
}
