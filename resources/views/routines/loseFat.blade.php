<!-- resources/views/your-view-file.blade.php -->

<x-app-layout>
    <!-- Asegúrate de que este <meta> esté en tu <head> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <div class="container mx-auto p-4 md:p-6"> <!-- Ajusta el padding para móvil -->
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-4">Rutina para Perder Grasa</h2> <!-- Ajusta el tamaño de la fuente para móvil -->

       

        <!-- Skeleton Loader -->
        <div id="skeleton-loader" class="space-y-4">
            @for ($i = 0; $i < 4; $i++)
            <div class="skeleton-loader bg-gray-200 h-12 rounded-lg"></div>
            @endfor
        </div>

        <!-- Rutina -->
        <div id="routine-content" class="hidden">
            @foreach ($routine as $day => $details)
            <div x-data="{ 
                    open: false, 
                    completedExercises: 0, 
                    totalExercises: {{ count($details['exercises']) * 3 }}, 
                    muscleExerciseCompletion: {
                        @foreach ($details['exercises'] as $muscle => $exercises)
                            '{{ $muscle }}': Array({{ count($exercises) }}).fill(false),
                        @endforeach
                    }
                }" class="mb-6">

                <button @click="open = !open" 
                    class="shine flex items-center justify-between w-full text-lg md:text-xl font-semibold py-8 px-4 rounded-lg" 
                    style="background-image: url('{{ asset($dayImages[$day]) }}'); background-size: cover; background-repeat: no-repeat; background-position: center;" 
                    :class="{'bg-green-200': completedExercises === totalExercises, 'bg-gray-100': completedExercises < totalExercises }">
                    <span x-show="completedExercises === totalExercises" class="text-green-500 mr-2">✓</span>
                    {{ $day }} - {{ implode(', ', array_map(fn($muscle) => $muscleTranslations[$muscle] ?? $muscle, $details['muscles'])) }}
                    <span x-show="!open">+</span>
                    <span x-show="open">-</span>
                </button>

                <div x-show="open" class="mt-4">
                    @foreach ($details['exercises'] as $muscle => $exercises)
                        <h4 class="text-lg font-semibold text-gray-600 mt-4">{{ $muscleTranslations[$muscle] ?? ucfirst($muscle) }}</h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-2"> <!-- Ajuste de espacio -->
                            @foreach ($exercises as $index => $exercise)
                                <div class="card bg-white rounded-lg shadow-lg p-4 transition-transform transform hover:scale-105">
                                    <div class="aspect-w-1 aspect-h-1 mb-4 w-24 h-24 mx-auto">
                                        <img src="{{ asset('gifs/' . $exercise->exercise_id . '.gif') }}" alt="{{ $exercise->name }}" class="w-full h-full object-contain rounded-lg">
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $exercise->name }}</h3>
                                    <p class="text-gray-600">Series: <span class="font-medium">{{ $details['series'] }}</span></p>
                                    <p class="text-gray-600">Reps: <span class="font-medium">{{ $details['reps'] }}</span></p>
                                    <p class="text-gray-600">Equipo: <span class="font-medium">{{ $exercise->equipment }}</span></p>
                                    
                                    <input type="checkbox" 
                                        @click="
                                            muscleExerciseCompletion['{{ $muscle }}'][{{ $index }}] = $event.target.checked;
                                            completedExercises = Object.values(muscleExerciseCompletion).flat().filter(Boolean).length;
                                        " 
                                        class="mt-2 cursor-pointer">
                                    <label class="ml-2 text-gray-700">Completar</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/routines.js'])

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Simulación de carga de datos
            setTimeout(function() {
                // Ocultar el skeleton loader y mostrar el contenido de la rutina
                document.getElementById("skeleton-loader").classList.add("hidden");
                document.getElementById("routine-content").classList.remove("hidden");
            }, 2000); // Ajusta el tiempo según la duración de la carga real
        });
    </script>
</x-app-layout>
