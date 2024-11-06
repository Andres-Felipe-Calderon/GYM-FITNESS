<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use Illuminate\Http\Request;

class SuggestedRoutineController extends Controller
{
    public function gainMuscle()
    {
        $muscleTranslations = [
            'quads' => 'Cuádriceps',
            'calves' => 'Pantorrillas',
            'pectorals' => 'Pectorales',
            'biceps' => 'Bíceps',
            'triceps' => 'Tríceps',
            'upper back' => 'Espalda',
            'glutes' => 'Glúteos',
            'hamstrings' => 'Isquiotibiales',
            'lats' => 'Dorsales',
            'abs' => 'Abdominales',
        ];
    
        // Asignar imágenes a cada día
        $dayImages = [
            'Lunes' => 'images/banner1.jpg',
            'Martes' => 'images/martes.jpg',
            'Miércoles' => 'images/miercoles.jpg',
            'Jueves' => 'images/jueves.jpg',
            'Viernes' => 'images/viernes.jpg',
            'Sábado' => 'images/sabado.jpg',
            'Domingo' => 'images/domingo.jpg',
        ];
    
        $routine = [
            'Lunes' => ['muscles' => ['quads', 'calves'], 'series' => 4, 'reps' => 12],
            'Martes' => ['muscles' => ['pectorals', 'biceps'], 'series' => 4, 'reps' => 10],
            'Miércoles' => ['muscles' => ['glutes', 'hamstrings'], 'series' => 4, 'reps' => 12],
            'Jueves' => ['muscles' => ['upper back', 'triceps'], 'series' => 4, 'reps' => 10],
            'Viernes' => ['muscles' => ['abs'], 'series' => 4, 'reps' => 15],
        ];
    
        foreach ($routine as $day => &$details) {
            foreach ($details['muscles'] as $muscle) {
                $exercises = Ejercicio::where('target', $muscle)
                    ->whereIn('equipment', ['barbell', 'dumbbell', 'machine', 'body weight', 'band'])
                    ->take(3)
                    ->get();
    
                // Debugging
                if ($muscle === 'upper back' && $exercises->isEmpty()) {
                    dd("No hay ejercicios para la espalda en la base de datos.");
                }
    
                $details['exercises'][$muscle] = $exercises;
            }
            
            // Agregar la imagen del día a los detalles
            $details['image'] = asset($dayImages[$day]);
        }
    
        return view('routines.gainMuscle', compact('routine', 'dayImages', 'muscleTranslations'));
    }
    
    public function loseFat()
    {
        $muscleTranslations = [
            'cardiovascular system' => 'Cardio', 
            'core' => 'Núcleo',
            'legs' => 'Piernas',
            'delts' => 'Hombros', // Utilizando 'delts' para hombros
            'upper back' => 'Espalda', 
            'quads' => 'Cuádriceps', 
            'hamstrings' => 'Isquiotibiales', 
        ];
    
        // Asignar imágenes a cada día
        $dayImages = [
            'Lunes' => 'images/banner1.jpg',
            'Miércoles' => 'images/miercoles.jpg',
            'Viernes' => 'images/viernes.jpg',
            'Sábado' => 'images/martes.jpg',
        ];
    
        $routine = [
            'Lunes' => ['muscles' => ['cardiovascular system'], 'series' => 3, 'reps' => '30 min'],
            'Miércoles' => ['muscles' => ['abs'], 'series' => 4, 'reps' => 15],
            'Viernes' => ['muscles' => ['quads', 'hamstrings'], 'series' => 4, 'reps' => 12],
            'Sábado' => ['muscles' => ['delts', 'upper back'], 'series' => 3, 'reps' => 10],
        ];
    
        foreach ($routine as $day => &$details) {
            foreach ($details['muscles'] as $muscle) {
                // Primero intentar obtener ejercicios con filtro de equipamiento
                $exercises = Ejercicio::where('target', $muscle)
                    ->whereIn('equipment', ['body weight', 'cardio equipment'])
                    ->take(4)
                    ->get();
    
                // Si no hay suficientes ejercicios, buscar sin el filtro de equipamiento
                if ($exercises->count() < 4) {
                    $needed = 4 - $exercises->count(); // Cuántos más se necesitan
    
                    // Obtener más ejercicios sin el filtro de equipamiento
                    $additionalExercises = Ejercicio::where('target', $muscle)
                        ->whereNotIn('equipment', ['body weight', 'cardio equipment'])
                        ->take($needed)
                        ->get();
    
                    // Combinar ejercicios ya obtenidos con los adicionales
                    $exercises = $exercises->merge($additionalExercises)->take(4);
                }
    
                $details['exercises'][$muscle] = $exercises;
            }
    
            // Agregar la imagen del día a los detalles
            $details['image'] = asset($dayImages[$day]);
        }
    
        return view('routines.loseFat', compact('routine', 'dayImages', 'muscleTranslations'));
    }
    
    public function tone()
    {
        $muscleTranslations = [
            'triceps' => 'Tríceps', // Cambia 'arms' a 'triceps' o agrega más según tus necesidades
            'quads' => 'Cuádriceps', // Puedes usar quads para las piernas
            'abs' => 'Abdominales', // Cambia 'core' a 'abs'
        ];
    
        // Asignar imágenes a cada día
        $dayImages = [
            'Martes' => 'images/martes.jpg',
            'Jueves' => 'images/jueves.jpg',
            'Sábado' => 'images/viernes.jpg',
        ];
    
        $routine = [
            'Martes' => ['muscles' => ['triceps'], 'series' => 4, 'reps' => 12], // Cambia 'arms' a 'triceps'
            'Jueves' => ['muscles' => ['quads'], 'series' => 4, 'reps' => 12], // Cambia 'legs' a 'quads'
            'Sábado' => ['muscles' => ['abs'], 'series' => 4, 'reps' => 15], // Cambia 'core' a 'abs'
        ];
    
        foreach ($routine as $day => &$details) {
            foreach ($details['muscles'] as $muscle) {
                $exercises = Ejercicio::where('target', $muscle)
                    ->where('equipment', '!=', 'heavy equipment')
                    ->take(4)
                    ->get();
    
                $details['exercises'][$muscle] = $exercises;
            }
    
            // Agregar la imagen del día a los detalles
            $details['image'] = asset($dayImages[$day]);
        }
    
        return view('routines.tone', compact('routine', 'dayImages', 'muscleTranslations'));
    }
}
