<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'body_part',
        'equipment',
        'gif_url',
        'exercise_id',
        'name',
        'target',
        'secondary_muscles',
        'instructions',
    ];

    protected $casts = [
        'secondary_muscles' => 'array', // Para que Laravel trate este campo como JSON
    ];
}
