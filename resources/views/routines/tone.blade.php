<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold text-center mb-6">Rutina para Tonificar</h2>

    <div class="flex justify-start mb-4">
        <a href="/dashboard" class="inline-flex flex-col items-center text-gray-700 bg-gray-300 hover:bg-gray-400 transition duration-300 ease-in-out w-16 h-16 rounded-md shadow-md transform hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4 10v10h16V10" />
            </svg>
            <span class="text-sm">Home</span>
        </a>
    </div>

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
            class="shine flex items-center justify-between w-full text-xl font-semibold py-12 px-4 rounded-lg" 
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
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-2">
                    @foreach ($exercises as $index => $exercise)
                        <div class="card bg-white rounded-lg shadow-lg p-4 transition-transform transform hover:scale-105">
                            <div class="aspect-w-1 aspect-h-1 mb-4 w-24 h-24 mx-auto">
                                <img src="{{ asset('gifs/' . $exercise->exercise_id . '.gif') }}" alt="{{ $exercise->name }}" class="w-full h-full object-contain rounded-lg">
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">{{ $exercise->name }}</h3>
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

@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/routines.js'])
