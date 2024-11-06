<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class GoogleTranslateController extends Controller
{
    public function translate(Request $request)
    {
        // Obtener el array de textos desde la solicitud
        $texts = $request->input('texts');
        $source = $request->input('source', 'en');
        $target = $request->input('target', 'es');

        $translator = new GoogleTranslate();
        $translator->setSource($source);
        $translator->setTarget($target);

        $translatedTexts = [];

        // Traducir cada texto y almacenar el resultado en un array
        foreach ($texts as $text) {
            $translatedTexts[] = $translator->translate($text);
        }

        // Retornar las traducciones en formato JSON
        return response()->json(['translatedTexts' => $translatedTexts]);
    }
}
