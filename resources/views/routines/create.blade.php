<meta name="csrf-token" content="{{ csrf_token() }}">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Rutina') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                  

                    <!-- Alertas para mostrar mensajes de éxito o error -->
                    <div id="alerta-exito" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">¡Éxito!</strong>
                        <span class="block sm:inline">La rutina ha sido guardada correctamente.</span>
                        <span id="cerrarAlertaExito" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Cerrar</title>
                                <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.586 7.066 4.652A1 1 0 105.652 6.066L8.586 9l-2.934 2.934a1 1 0 101.414 1.414L10 10.414l2.934 2.934a1 1 0 001.414-1.414L11.414 9l2.934-2.934z"/>
                            </svg>
                        </span>
                    </div>

                    <div id="alerta-error" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">¡Error!</strong>
                        <span class="block sm:inline">Hubo un problema al guardar la rutina. Inténtalo nuevamente.</span>
                        <span id="cerrarAlertaError" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Cerrar</title>
                                <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.586 7.066 4.652A1 1 0 105.652 6.066L8.586 9l-2.934 2.934a1 1 0 101.414 1.414L10 10.414l2.934 2.934a1 1 0 001.414-1.414L11.414 9l2.934-2.934z"/>
                            </svg>
                        </span>
                    </div>
                    <form id="crearRutinaForm" class="space-y-4">
    <div class="form-group">
        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la
            Rutina:</label>
        <input type="text" id="nombre" name="nombre"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"
            placeholder="Nombre de la rutina" required>
    </div>

    <div class="form-group">
        <label for="descripcion"
            class="block text-sm font-medium text-gray-700">Descripción:</label>
        <textarea id="descripcion" name="descripcion"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"
            rows="3" placeholder="Descripción de la rutina" required></textarea>
    </div>

    <div class="form-group">
        <label for="parte" class="block text-sm font-medium text-gray-700">Selecciona una parte del
            cuerpo:</label>
        <select id="parte" name="parte"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2"
            required>
            <option value="">Selecciona...</option>
            <option value="pectorals">Pectorals</option>
            <option value="abs">Abs</option>
            <option value="biceps">Biceps</option>
            <option value="triceps">Triceps</option>
            <option value="calves">Calves</option>
            <option value="delts">Delts</option>
            <option value="forearms">Forearms</option>
            <option value="upper back">Upper Back</option>
            <option value="quads">Quads</option>
            <option value="hamstrings">Hamstrings</option>
            <option value="glutes">Glutes</option>
            <option value="adductors">Adductors</option>
        </select>
    </div>
    <div class="flex items-center space-x-4 mt-2">
        <!-- Botón de Obtener Ejercicios -->
        <button type="button" id="obtenerEjercicios"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Obtener Ejercicios
        </button>

        <!-- Botón de Guardar Rutina -->
        <button type="submit"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            Guardar Rutina
        </button>
    </div>
    <div id="ejercicios" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/routines.js'])
</x-app-layout>
