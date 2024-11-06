<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EjercicioController extends Controller
{
    public function obtenerYGuardarEjercicios($parte)
{
    $response = Http::withHeaders([
        'X-RapidAPI-Host' => 'exercisedb.p.rapidapi.com',
        'X-RapidAPI-Key' => env('RAPIDAPI_KEY'),
    ])->get("https://exercisedb.p.rapidapi.com/exercises/target/{$parte}");

    $data = $response->json();

    // Imprime la respuesta para verificar el contenido
   

    foreach ($data as $ejercicio) {
     // Esto mostrará cada ejercicio antes de la inserción
        Ejercicio::create([
            'body_part' => $ejercicio['bodyPart'],
            'equipment' => $ejercicio['equipment'],
            'gif_url' => $ejercicio['gifUrl'],
            'name' => $ejercicio['name'],
            'target' => $ejercicio['target'],
            'secondary_muscles' => isset($ejercicio['secondaryMuscles']) ? json_encode($ejercicio['secondaryMuscles']) : null,
            'instructions' => isset($ejercicio['instructions']) ? json_encode($ejercicio['instructions']) : null,
            'exercise_id' => $ejercicio['id'] // Asegúrate de que 'id' esté presente
        ]);
    }
    
}
public function obtenerEjerciciosPorParte($parte) {
    try {
        // Asegúrate de que 'parte' sea un campo válido en tu base de datos
        $ejercicios = Ejercicio::where('target', $parte)->get(); // Cambiar 'parte' a 'target'

        // Verificar si se encontraron ejercicios
        if ($ejercicios->isEmpty()) {
            return response()->json(['message' => 'No hay ejercicios disponibles.'], 404);
        }

        return response()->json($ejercicios);
    } catch (\Exception $e) {
        // Registrar el error para el desarrollo
        \Log::error('Error al obtener ejercicios: ' . $e->getMessage());

        return response()->json(['error' => 'Error al obtener ejercicios: ' . $e->getMessage()], 500);
    }
}
public function obtenerEjercicioPorNombre($nombre) {
    try {
        // Asegúrate de que 'nombre' sea un campo válido en tu base de datos
        $ejercicio = Ejercicio::where('name', 'like', '%' . $nombre . '%')->first(); // Cambia a 'name'

        // Verificar si se encontró el ejercicio
        if (!$ejercicio) {
            return response()->json(['message' => 'Ejercicio no encontrado.'], 404);
        }

        return response()->json($ejercicio);
    } catch (\Exception $e) {
        // Registrar el error para el desarrollo
        \Log::error('Error al obtener el ejercicio: ' . $e->getMessage());

        return response()->json(['error' => 'Error al obtener el ejercicio: ' . $e->getMessage()], 500);
    }
}


    
}
