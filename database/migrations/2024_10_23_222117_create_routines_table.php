<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutinesTable extends Migration
{
    public function up()
    {
        Schema::create('routines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Agregar la referencia al usuario
            $table->string('nombre');
            $table->text('descripcion');
            $table->string('parte');
            $table->json('ejercicios'); // Campo ejercicios como JSON
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('routines');
    }
}
