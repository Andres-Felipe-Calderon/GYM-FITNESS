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
        // Paso 1: Agregar la columna is_active
        Schema::table('users', function (Blueprint $table) {
            // Agregamos la columna is_active, inicialmente estableceremos todos los registros existentes como activos.
            $table->boolean('is_active')->default(true);
        });

        // Paso 2: Cambiar el valor predeterminado a false para los nuevos usuarios
        DB::statement("UPDATE users SET is_active = 1"); // Mantener a los usuarios existentes como activos

        // Cambiar el valor predeterminado para futuros registros
        Schema::table('users', function (Blueprint $table) {
            // Cambiar el valor predeterminado a false para nuevos registros
            $table->boolean('is_active')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir cambios eliminando la columna is_active
            $table->dropColumn('is_active');
        });
    }
};
