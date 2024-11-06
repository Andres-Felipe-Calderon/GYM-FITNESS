<?php
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\GoogleTranslateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SuggestedRoutineController;
// routes/api.php

use App\Http\Controllers\ExerciseController;


// Ruta para la API de Google Translate
Route::post('/google-translate', [GoogleTranslateController::class, 'translate']);

// Ruta para obtener la lista de partes del cuerpo
Route::get('/exercises/targetList', [ExerciseController::class, 'targetList']);
Route::get('/ejercicios/{parte}', [RoutineController::class, 'obtenerEjercicios']);
Route::get('/routines/create', [RoutineController::class, 'create'])->name('routines.create');
Route::post('/routines', [RoutineController::class, 'store'])->name('routines.store');
Route::get('/routines/{id}', [RoutineController::class, 'showApi']);
Route::get('/myassignacion', [AssignmentController::class, 'myAssignacion'])->middleware('auth');
Route::get('/routines/gain-muscle', [SuggestedRoutineController::class, 'gainMuscle'])->name('routines.gainMuscle');
Route::get('/routines/lose-fat', [SuggestedRoutineController::class, 'loseFat'])->name('routines.loseFat');
Route::get('/routines/tone', [SuggestedRoutineController::class, 'tone'])->name('routines.tone');