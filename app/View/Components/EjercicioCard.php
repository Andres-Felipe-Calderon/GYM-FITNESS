<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EjercicioCard extends Component
{
    public $ejercicio;

    public function __construct($ejercicio)
    {
        $this->ejercicio = $ejercicio;
    }

    public function render()
    {
        return view('components.ejercicio-card');
    }
}

