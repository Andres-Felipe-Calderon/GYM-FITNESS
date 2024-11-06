<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Ejercicio;

class DescargarEjercicios extends Command
{
    protected $signature = 'ejercicios:descargar';
    protected $description = 'Descargar GIFs de ejercicios y almacenar en la base de datos';

    public function handle()
{
    $ejercicios = Ejercicio::all();

    foreach ($ejercicios as $ejercicio) {
        // Verificar si ya existe el archivo GIF en el sistema
        $nombreArchivo = $ejercicio->id . '.gif';
        $rutaArchivo = public_path('gifs/' . $nombreArchivo);

        // Si el archivo ya existe, saltar a la siguiente iteración
        if (file_exists($rutaArchivo)) {
            $this->info('GIF ya guardado para: ' . $ejercicio->name);
            continue; // Omitir la descarga si ya existe
        }

        // Realiza la solicitud a la API para descargar el GIF
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'exercisedb.p.rapidapi.com',
            'x-rapidapi-key' => '7aa44562c7mshe067078f1a52acdp1e9004jsnee597cd6a3eb', // Tu clave API aquí
            'Content-Type' => 'application/json'
        ])->get($ejercicio->gif_url); // Asegúrate de que gif_url contenga la URL correcta

        // Comprobar si la respuesta fue exitosa
        if ($response->successful()) {
            // Guardar el contenido del GIF en el archivo
            file_put_contents($rutaArchivo, $response->body());
            // Actualizar la URL del GIF en la base de datos (opcional, si es necesario)
            $ejercicio->update(['gif_url' => url('gifs/' . $nombreArchivo)]);
            $this->info('GIF descargado para: ' . $ejercicio->name);
        } else {
            // Imprimir información de error detallada
            $this->error('Error al descargar el GIF para el ejercicio: ' . $ejercicio->name);
            $this->error('Código de estado: ' . $response->status());
            $this->error('Cuerpo de la respuesta: ' . $response->body());
        }
    }
}

    

}
