<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Http;

class ExerciseService
{
    protected $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
        $this->translator->setSource('en'); // Idioma de origen
        $this->translator->setTarget('es'); // Idioma de destino
    }

    public function obtenerEjercicios($parte)
    {
        // Llamada a la API de ejercicios
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'exercisedb.p.rapidapi.com',
            'x-rapidapi-key' => '43d5ad9f6fmshc2c018a26a070a6p108bfbjsndc673c100a7e' // Reemplaza con tu API Key
        ])->get("https://exercisedb.p.rapidapi.com/exercises/bodyPart/{$parte}");

        if ($response->successful()) {
            $ejercicios = $response->json();

            // Traducir cada ejercicio
            foreach ($ejercicios as &$ejercicio) {
                $ejercicio = $this->traducirEjercicio($ejercicio);
            }

            return $ejercicios;
        }

        return []; // Manejar el error según tu lógica
    }

    public function obtenerEjercicioPorId($id)
    {
        // Llamada a la API para obtener un ejercicio específico
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'exercisedb.p.rapidapi.com',
            'x-rapidapi-key' => '43d5ad9f6fmshc2c018a26a070a6p108bfbjsndc673c100a7e' // Reemplaza con tu API Key
        ])->get("https://exercisedb.p.rapidapi.com/exercises/exercise/{$id}");

        if ($response->successful()) {
            $ejercicio = $response->json();
            return $this->traducirEjercicio($ejercicio); // Traducir la información del ejercicio
        }

        return null; // O manejar el error según tu lógica
    }

    protected function traducirEjercicio($ejercicio)
    {
        $ejercicio['name'] = $this->translator->translate($ejercicio['name']);
        $ejercicio['instructions'] = $this->traducirInstrucciones($ejercicio['instructions']);
        $ejercicio['bodyPart'] = $this->translator->translate($ejercicio['bodyPart']);
        $ejercicio['equipment'] = $this->translator->translate($ejercicio['equipment']);
        $ejercicio['target'] = $this->translator->translate($ejercicio['target']);

        return $ejercicio;
    }

    protected function traducirInstrucciones($instrucciones)
    {
        // Asegúrate de que `instrucciones` sea un array
        $instruccionesArray = is_array($instrucciones) ? $instrucciones : [$instrucciones];

        // Traducir cada instrucción
        return array_map(function($instruction) {
            return $this->translator->translate($instruction);
        }, $instruccionesArray);
    }
}
