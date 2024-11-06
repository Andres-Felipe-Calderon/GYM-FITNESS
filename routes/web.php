<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\AdminController; 
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\GoogleTranslateController;
use App\Http\Controllers\EjercicioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\MedidasController; // Cambia a MedidasController
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckUserStatus;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\SuggestedRoutineController;


Route::get('/users', [UserController::class, 'index'])->name('users.index');

Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

Route::get('/admin', function (Request $request) {
    $adminMiddleware = new AdminMiddleware();
    return $adminMiddleware->handle($request, function ($request) {
        return (new AdminController())->index();
    });
})->name('administrador.index');



Route::post('/download-gif', function (Request $request) {
    $gifUrl = $request->input('gifUrl');
    $id = $request->input('id');

    // Define la ruta donde se almacenará el GIF
    $gifPath = public_path("gifs/{$id}.gif");

    // Realiza la solicitud para descargar el GIF
    $response = Http::get($gifUrl);

    if ($response->successful()) {
        file_put_contents($gifPath, $response->body());
        return response()->json(['success' => true]);
    } else {
        return response()->json(['success' => false, 'error' => 'No se pudo descargar el GIF'], 500);
    }
});

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', UserMiddleware::class])->group(function () {
    Route::get('/dashboard', function () {
        return response()->view('dashboard')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    })->name('dashboard');
});

// Grupo de rutas que requieren autenticación
Route::middleware(['auth', UserMiddleware::class])->group(function () {
    Route::get('/routines/gain-muscle', [SuggestedRoutineController::class, 'gainMuscle'])->name('routines.gainMuscle');
    Route::get('/routines/lose-fat', [SuggestedRoutineController::class, 'loseFat'])->name('routines.loseFat');
    Route::get('/routines/tone', [SuggestedRoutineController::class, 'tone'])->name('routines.tone');
});

Route::get('/routines/lose-fat', [SuggestedRoutineController::class, 'loseFat'])->name('routines.loseFat');
Route::get('/routines/tone', [SuggestedRoutineController::class, 'tone'])->name('routines.tone');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboardadmin'])->name('admin.dashboard');    // Otras rutas del admin
});
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    
    
Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    // Rutas de perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Nuevas rutas para "Crear Rutina", "Ver Ejercicios" y "Ver Rutinas"

    Route::get('/medidas', [MedidasController::class, 'index'])->name('medidas.index');
    Route::post('/medidas', [MedidasController::class, 'store'])->name('medidas.store');    Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
    Route::get('/ejercicios/{parte}', [EjercicioController::class, 'obtenerYGuardarEjercicios']);
    Route::get('/ejercicios', [ExerciseController::class, 'obtenerEjercicios']);
    Route::get('/ejercicio/{id}', [ExerciseController::class, 'obtenerEjercicio']);
    Route::get('/ejercicios/index', [ExerciseController::class, 'index']); // Para mostrar la vista de ejercicios
    Route::post('/google-translate', [GoogleTranslateController::class, 'translate']);
    Route::get('/ejercicios/{parte}', [EjercicioController::class, 'obtenerEjerciciosPorParte']);
    Route::get('/ejercicios/nombre/{nombre}', [EjercicioController::class, 'obtenerEjercicioPorNombre']);

    Route::get('/routines/create', [RoutineController::class, 'create'])->name('routines.create');
    Route::post('/routines', [RoutineController::class, 'store'])->name('routines.store');
Route::get('/api/routines', [RoutineController::class, 'apiIndex'])->name('routines.api');
    Route::delete('/routines/{routine}', [RoutineController::class, 'destroy'])->name('routines.destroy');
    Route::get('/routines/{routine}/edit', [RoutineController::class, 'edit'])->name('routines.edit');
    Route::get('/routines', [RoutineController::class, 'index'])->name('routines.ver');
    Route::get('/routines/{routine}', [RoutineController::class, 'show'])->name('routines.show');
    Route::post('routines/assign/{id}', [AssignmentController::class, 'store']);

Route::get('/routines/{id}', [RoutineController::class, 'showApi']);
Route::get('/myAssignments', [AssignmentController::class, 'myAssignments'])->withoutMiddleware('auth');

});


require __DIR__ . '/auth.php';
