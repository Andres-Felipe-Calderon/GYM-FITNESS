<?php

// app/Http/Controllers/RoutineController.php

namespace App\Http\Controllers;

use App\Models\Routine; // Asegúrate de importar el modelo Routine
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RoutineController extends Controller
{
    public function create()
{
    // Asignar los objetivos (músculos) a la lista de targets
    $targets = [
        "abductors",
        "abs",
        "adductors",
        "biceps",
        "calves",
        "cardiovascular system",
        "delts",
        "forearms",
        "glutes",
        "hamstrings",
        "lats",
        "levator scapulae",
        "pectorals",
        "quads",
        "serratus anterior",
        "spine",
        "traps",
        "triceps",
        "upper back"
    ];

    return view('routines.create', compact('targets')); // Pasa la lista de partes a la vista
}

    
    public function index()
    {
        $routines = auth()->user()->routines; // Asegúrate de que la relación esté definida en el modelo User
    return view('routines.ver', compact('routines')); // Pasa las rutinas a la vista
    }
    public function apiIndex()
{
   
    $routines = auth()->user()->routines; // Obtener rutinas del usuario autenticado
    return response()->json($routines); // Devolver como JSON
}


    

    public function store(Request $request)
    {
        try {
            // Validar la solicitud
            $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'required|string',
                'parte' => 'required|string',
                'ejercicios' => 'required|array', // Asegúrate de que ejercicios es un array
            ]);
            
            $routine = new Routine(); // Crear nueva instancia del modelo Routine
            $routine->nombre = $request->nombre; // Asignar nombre
            $routine->descripcion = $request->descripcion; // Asignar descripción
            $routine->parte = $request->parte; // Asignar parte del cuerpo
            $routine->ejercicios = json_encode($request->ejercicios); // Almacenar como JSON
            $routine->user_id = auth()->id(); // Asignar el ID del usuario autenticado
    
            // Depuración: mostrar el modelo y sus propiedades antes de guardar
            // dd($routine); 
    
            $routine->save(); // Guardar la rutina en la base de datos
            
            return response()->json(['message' => 'Rutina creada exitosamente.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422); // 422 para errores de validación
        } catch (\Exception $e) {
            \Log::error('Error al guardar la rutina: ' . $e->getMessage());
            return response()->json(['error' => 'Error al guardar la rutina.'], 500);
        }
    }
    // app/Http/Controllers/RoutineController.php

public function edit($id)
{
    // Busca la rutina por ID, asegurándote de que el usuario autenticado sea el propietario
    $routine = Routine::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    
    return view('routines.edit', compact('routine')); // Pasa la rutina a la vista de edición
}
// app/Http/Controllers/RoutineController.php

public function destroy($id)
{
    $routine = Routine::findOrFail($id); // Busca la rutina por ID
    $routine->delete(); // Elimina la rutina

    return response()->json(['message' => 'Rutina eliminada exitosamente.']);
}

public function show($id)
{
    $routine = Routine::findOrFail($id); // Busca la rutina por ID
    return view('routines.show', compact('routine')); // Muestra los detalles de la rutina
}
public function showApi($id)
{
    $routine = Routine::findOrFail($id); // Busca la rutina por ID
    return response()->json($routine); // Devuelve los detalles de la rutina como JSON
}



}
