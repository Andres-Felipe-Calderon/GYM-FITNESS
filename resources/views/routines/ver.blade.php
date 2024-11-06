<meta name="csrf-token" content="{{ csrf_token() }}">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ver Rutinas') }}
        </h2>
    </x-slot>

    <!-- Modal de Detalles -->
    <div id="detailsModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-2/3 max-w-2xl">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold">Detalles de la Rutina</h2>
                <button id="closeModal" class="text-red-600 font-bold">Cerrar</button>
            </div>
            <div id="modalContent" class="mt-4 max-h-[60vh] overflow-y-auto">
                <!-- Aquí se mostrarán los detalles dinámicamente -->
            </div>
        </div>
    </div>
    <div class="w-full pt-16 bg-white p-6 rounded-lg shadow-md"> <!-- Ocupar todo el ancho y separar de arriba -->
    <div class="bg-white shadow-md rounded-lg  ">
        <!-- Contenido del segundo div -->
    <!-- Contenido -->
    <table class="min-w-full border-collapse border border-gray-300">
    <thead class="bg-gray-200">
        <tr>
            <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 uppercase">Nombre</th> <!-- Cambiado a text-center -->
            <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 uppercase">Descripción</th> <!-- Cambiado a text-center -->
            <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 uppercase">Acciones</th> <!-- Cambiado a text-center -->
        </tr>
    </thead>
    <tbody>
        <!-- Aquí van los datos de las filas -->
    </tbody>
</table>

</div>




        <div class="flex justify-start mt-4">
            <button id="verCalendario" class="flex items-center justify-center w-12 h-12 bg-green-500 text-white rounded-full hover:bg-green-600 transition-colors">
                <i class="fas fa-calendar-alt"></i> <!-- Icono de calendario -->
            </button>
        </div>

        <!-- Contenedor del calendario -->
        <div id="calendarModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-2xl">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold">Calendario</h2>
                    <button id="closeCalendarModal" class="text-red-600 font-bold">Cerrar</button>
                </div>
                <div id="calendar" class="mt-4 w-full"></div> <!-- Contenedor del calendario -->
            </div>
        </div>
        <!-- Modal para Asignación -->
        <div id="asignarModal" class="hidden fixed inset-0 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg relative max-w-sm w-full">
        <button id="closeModal1" class="absolute top-2 right-2 text-red-600 hover:text-red-800 transition-colors">
            <i class="fas fa-times text-xl"></i> <!-- Icono de cerrar con tamaño aumentado -->
        </button>
        <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Asignar Rutina</h2>
        
        <form id="asignarForm">
            <input type="hidden" name="routine_id" id="routine_id" value="">

            <div class="mb-6">
                <label for="date" class="block mb-2 text-gray-600 font-medium">Selecciona un día:</label>
                <input type="date" name="date" id="date" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50">Asignar</button>
        </form>
    </div>
</div>



    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/routines.js'])<!-- Agregar en la vista Blade donde se encuentre el botón de eliminar -->



</x-app-layout>
