<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use App\Models\User;
use App\Models\RoutineAssignment; // Asegúrate de importar el modelo
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    // Muestra el formulario para asignar una rutina
    public function create($id)
    {
        $routine = Routine::findOrFail($id);
        $users = User::all(); // Obtener todos los usuarios

        return view('assignments.create', compact('routine', 'users'));
    }

    // Maneja la asignación de la rutina
    public function store(Request $request, $id)
    {
        try {
            $request->validate([
                'date' => 'required|date',
            ]);
    
            $routine = Routine::findOrFail($id);
            $userId = auth()->id();
    
            RoutineAssignment::create([
                'routine_id' => $routine->id,
                'user_id' => $userId,
                'date' => $request->date,
            ]);
    
            return response()->json(['message' => 'Rutina asignada correctamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al asignar la rutina: ' . $e->getMessage()], 500);
        }
    }

    // Cambiamos el nombre de este método a myAssignments
    public function myAssignments()
    {
        $userId = auth()->id(); // Obtiene el ID del usuario autenticado
        
        if (!$userId) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }
    
        // Obtener las asignaciones del usuario autenticado
        $assignments = RoutineAssignment::where('user_id', $userId)
            ->with('routine') // Cargar la relación 'routine'
            ->get();
    
        if ($assignments->isEmpty()) {
            return response()->json(['message' => 'No hay rutinas asignadas.'], 404);
        }
    
        // Transformar los datos para el calendario
        $events = $assignments->map(function($assignment) {
            return [
                'title' => $assignment->routine ? $assignment->routine->nombre : 'Rutina no disponible', // Verifica si existe la rutina
                'start' => $assignment->date,
                'end' => $assignment->date,
                'allDay' => true
            ];
        });
    
        return response()->json($events);
    }
    
    
    
}
