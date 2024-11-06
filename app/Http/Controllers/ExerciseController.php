<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ExerciseService;

class ExerciseController extends Controller
{
    protected $exerciseService;

    public function __construct(ExerciseService $exerciseService)
    {
        $this->exerciseService = $exerciseService;
    }

    // Método para mostrar la vista de ejercicios
    public function index()
    {
        return view('exercises.index');
    }

    // Método para obtener ejercicios basado en la parte del cuerpo
    public function obtenerEjercicios(Request $request)
    {
        // Validación del parámetro 'parte'
        $validator = Validator::make($request->all(), [
            'parte' => 'required|string|in:back,chest,upper legs,arms,cardio,lower arms,lower legs,neck,shoulders,upper arms,waist', // Asegúrate de listar las partes válidas
        ]);
       
        if ($validator->fails()) {
            return response()->json(['error' => 'Parte del cuerpo no válida.'], 400);
        }

        $parte = $request->input('parte');

        // Obtener ejercicios desde el servicio
        $ejercicios = $this->exerciseService->obtenerEjercicios($parte);

        return response()->json($ejercicios);
    }

    // Método adicional para obtener detalles de un ejercicio
    public function obtenerEjercicio($id)
    {
        // Lógica para obtener un ejercicio específico utilizando el servicio
        $ejercicio = $this->exerciseService->obtenerEjercicioPorId($id); // Asegúrate de implementar este método en tu ExerciseService

        if (!$ejercicio) {
            return response()->json(['error' => 'Ejercicio no encontrado.'], 404);
        }

        return response()->json($ejercicio);
    }
}
