<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ejercicio; // Agregar la importación del modelo Ejercicio
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Primero, crea un usuario de prueba si lo necesitas
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Ejecuta el seeder de Ejercicios
        $this->call(EjercicioSeeder::class);
    }
}
