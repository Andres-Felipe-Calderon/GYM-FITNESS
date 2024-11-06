<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Listado de Ejercicios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-center items-center h-32">
                    <p class="text-2xl font-semibold animate-bounce">¡¡Presiona un Músculo Para ver los ejercicios.!!</p>
                </div>

                <div class="relative w-full h-auto">
                    <img src="{{ asset('images/cuerpo.jpeg') }}" alt="Cuerpo Humano" usemap="#bodymap" class="w-full h-auto">

                    <!-- Áreas con colores -->
                    <div class="absolute muscle" data-muscle="pectorals" style="top: 22%; left: 34%; width: 8%; height: 9%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="abs" style="top: 32%; left: 35%; width: 6%; height: 15%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="biceps" style="top: 30%; left: 31%; width: 3%; height: 10%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="biceps" style="top: 30%; left: 42%; width: 3%; height: 10%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="triceps" style="top: 30%; left: 66%; width: 3%; height: 10%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="triceps" style="top: 30%; left: 54%; width: 3%; height: 10%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="calves" style="top: 74%; left: 58%; width: 7%; height: 16%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="delts" style="top: 22%; left: 31%; width: 3%; height: 7%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="delts" style="top: 22%; left: 42%; width: 3%; height: 7%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="forearms" style="top: 40%; left: 43%; width: 3%; height: 12%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="forearms" style="top: 40%; left: 30%; width: 3%; height: 12%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="upper back" style="top: 22%; left: 58%; width: 7%; height: 20%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="quads" style="top: 50%; left: 33%; width: 3%; height: 20%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="quads" style="top: 50%; left: 40%; width: 3%; height: 20%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="hamstrings" style="top: 56%; left: 57%; width: 8%; height: 17%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="glutes" style="top: 46%; left: 56%; width: 10%; height: 10%; cursor: pointer;"></div>
<div class="absolute muscle" data-muscle="adductors" style="top: 52%; left: 36%; width: 4%; height: 10%; cursor: pointer;"></div>
<!--<div class="absolute border border-red-500 muscle" data-muscle="abductors" style="top: 50%; left: 30%; width: 3%; height: 10%; cursor: pointer;"></div>  abductors -->

                </div>

                <div id="ejercicios" class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 relative min-h-[200px]"></div>
    <!-- Mensaje de carga -->
    <div id="loading-message" class="text-center text-gray-600" style="display: none;">Cargando ejercicios...</div>
    <!-- Spinner de carga -->
    <div id="spinner" class="flex justify-center items-center" style="display: none;">Cargando...</div>

    <!-- Aquí se mostrarán los ejercicios -->


              
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/routines.js'])

</x-app-layout>
