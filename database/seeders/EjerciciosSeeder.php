<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class EjerciciosSeeder extends Seeder
{
    public function run()
    {
        // Ruta al archivo SQL
        $path = database_path('sql/ejercicios.sql');

        // Verifica si el archivo existe
        if (File::exists($path)) {
            // Lee el contenido del archivo SQL
            $sql = File::get($path);

            // Ejecuta el SQL en la base de datos
            DB::unprepared($sql);

            $this->command->info('Datos de ejercicios insertados correctamente desde ejercicios.sql');
        } else {
            $this->command->error('Archivo ejercicios.sql no encontrado en database/sql');
        }
    }
}
