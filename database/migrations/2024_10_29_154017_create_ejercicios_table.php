<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ejercicios', function (Blueprint $table) {
            $table->id(); // ID autoincremental para la tabla
            $table->string('body_part');
            $table->string('equipment');
            $table->string('gif_url');
            $table->string('exercise_id')->unique(); // ID del ejercicio desde la API
            $table->string('name');
            $table->string('target');
            $table->json('secondary_muscles')->nullable(); // En JSON para manejar múltiples músculos secundarios
            $table->json('instructions')->nullable(); // Cambiado a JSON para múltiples instrucciones
            $table->timestamps(); // Columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejercicios');
    }
};
