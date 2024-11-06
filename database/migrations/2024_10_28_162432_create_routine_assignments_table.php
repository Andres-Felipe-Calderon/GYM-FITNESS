<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutineAssignmentsTable extends Migration
{
    public function up()
    {
        Schema::create('routine_assignments', function (Blueprint $table) {
            $table->id();
            // Relación con la tabla 'routines'
            $table->foreignId('routine_id')->constrained('routines')->onDelete('cascade');
            // Almacena la fecha específica
            $table->date('date'); 
            // Relación con la tabla 'users'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('routine_assignments');
    }
}
