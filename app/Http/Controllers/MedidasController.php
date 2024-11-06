<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medida; // Asegúrate de importar el modelo Medida

class MedidasController extends Controller
{
    public function index()
    {
        // Obtener las medidas del usuario
        $medidas = Medida::where('user_id', auth()->id())->get();

        return view('medidas.index', compact('medidas'));
    }

    public function store(Request $request)
    {
        // Validar los datos ingresados
        $request->validate([
            'weight' => 'required|numeric',
            'height' => 'required|integer',
            'waist' => 'required|integer',
            'date' => 'required|date',
        ]);

        // Crear una nueva medida
        Medida::create([
            'user_id' => auth()->id(),
            'weight' => $request->weight,
            'height' => $request->height,
            'waist' => $request->waist,
            'date' => $request->date,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('medidas.index')->with('success', 'Medidas registradas correctamente.');
    }
}
