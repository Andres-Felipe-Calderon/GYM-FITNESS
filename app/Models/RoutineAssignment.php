<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoutineAssignment extends Model
{
    use HasFactory; // Usa el trait de Factory

    protected $table = 'routine_assignments'; // Nombre de la tabla

    protected $fillable = [
        'routine_id', // ID de la rutina
        'user_id',    // ID del usuario
        'date',       // Fecha de la asignación
    ];

    // Relación con Routine
    public function routine()
    {
        return $this->belongsTo(Routine::class, 'routine_id');
    }

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
