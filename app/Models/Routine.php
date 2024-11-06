<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory; // Asegúrate de usar HasFactory si necesitas la funcionalidad de fábrica

    // Especifica la tabla asociada (opcional, si el nombre de la tabla sigue la convención)
    protected $table = 'routines';

    // Especifica los atributos que se pueden asignar masivamente
    protected $fillable = [
        'user_id', // Asegúrate de incluir el user_id aquí
        'nombre',
        'descripcion',
        'parte',
        'ejercicios',
    ];

    // Si deseas que los atributos se conviertan a JSON automáticamente
    protected $casts = [
        'ejercicios' => 'array', // Convierte el campo 'ejercicios' a un array automáticamente
    ];

    // Agregar timestamps si tu tabla tiene las columnas created_at y updated_at
    public $timestamps = true;

    // Definir la relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Definir la relación con RoutineAssignment
    public function assignments()
    {
        return $this->hasMany(RoutineAssignment::class, 'routine_id');
    }
}
