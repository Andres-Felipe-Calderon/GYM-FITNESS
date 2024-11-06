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
        // Verifica si estás en un entorno local o de producción
        if (app()->environment('production')) {
            // Si estamos en producción, conecta a MySQL
            $ejercicios = \DB::connection('mysql')->table('ejercicios')->get();
        } else {
            // Si estamos en local (SQLite), usa la conexión local
            $ejercicios = \DB::connection('sqlite')->table('ejercicios')->get();
        }

        // Inserta los registros en la base de datos de producción (MySQL)
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
