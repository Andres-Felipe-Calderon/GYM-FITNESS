<x-admin-layout>
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-6">Panel de Administración</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card para Total de Usuarios -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-blue-500 rounded-full p-4">
                        <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Total de Usuarios</h2>
                    <p class="text-4xl font-bold">{{ $totalUsers }}</p>
                </div>
            </div>

            <!-- Card para Usuarios Activos -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-green-500 rounded-full p-4">
                        <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12l4.5-4.5m0 0L15 12l4.5 4.5M6 12l4.5-4.5m0 0L6 12l4.5 4.5" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Usuarios Activos</h2>
                    <p class="text-4xl font-bold">{{ $activeUsers }}</p>
                </div>
            </div>

            <!-- Card para Usuarios Inactivos -->
            <div class="bg-white shadow-lg rounded-lg p-6 flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <div class="bg-red-500 rounded-full p-4">
                        <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6M9 16h6M9 8h6" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">Usuarios Inactivos</h2>
                    <p class="text-4xl font-bold">{{ $inactiveUsers }}</p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
