<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedidasTable extends Migration
{
    public function up()
    {
        Schema::create('medidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relación con la tabla de usuarios
            $table->decimal('weight', 5, 2); // Peso en kg
            $table->integer('height'); // Altura en cm
            $table->integer('waist'); // Cintura en cm
            $table->date('date'); // Fecha de la medida
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medidas');
    }
}
