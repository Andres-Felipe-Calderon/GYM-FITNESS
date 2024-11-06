<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ejercicio;

class EjercicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtén los registros de la base de datos local
        $ejercicios = \DB::connection('mysql')->table('ejercicios')->get();  // Asegúrate de que 'mysql' sea tu conexión local

        // Inserta los registros en la base de datos de producción
        foreach ($ejercicios as $ejercicio) {
            Ejercicio::create([
                'body_part' => $ejercicio->body_part,
                'equipment' => $ejercicio->equipment,
                'gif_url' => $ejercicio->gif_url,
                'exercise_id' => $ejercicio->exercise_id,
                'name' => $ejercicio->name,
                'target' => $ejercicio->target,
                'secondary_muscles' => $ejercicio->secondary_muscles,
                'instructions' => $ejercicio->instructions,
            ]);
        }
    }
}

