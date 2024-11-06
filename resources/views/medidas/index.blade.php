<x-app-layout>

    <div class="container mx-auto bg-white p-6 mt-2 rounded-lg shadow-md w-full h-screen auto">
        <h1 class="text-2xl font-bold mb-6">Mis Medidas</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('medidas.store') }}" method="POST" class="mb-6">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Fecha</label>
                    <input type="date" name="date" id="date" class="border border-gray-300 rounded-lg w-full p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700">Peso (kg)</label>
                    <input type="number" name="weight" id="weight" class="border border-gray-300 rounded-lg w-full p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01" required>
                </div>
                <div>
                    <label for="height" class="block text-sm font-medium text-gray-700">Altura (cm)</label>
                    <input type="number" name="height" id="height" class="border border-gray-300 rounded-lg w-full p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label for="waist" class="block text-sm font-medium text-gray-700">Cintura (cm)</label>
                    <input type="number" name="waist" id="waist" class="border border-gray-300 rounded-lg w-full p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 transition">Registrar Medidas</button>
        </form>

        <!-- Tabla para mostrar las medidas -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Fecha</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Peso</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Altura</th>
                        <th class="py-3 px-4 text-left text-sm font-medium text-gray-700">Cintura</th>
                        <!-- Agrega más columnas según sea necesario -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($medidas as $medida)
                    <tr class="hover:bg-gray-100 transition">
                        <td class="py-3 px-4 border-b border-gray-300">{{ $medida->date }}</td>
                        <td class="py-3 px-4 border-b border-gray-300">{{ $medida->weight }} kg</td>
                        <td class="py-3 px-4 border-b border-gray-300">{{ $medida->height }} cm</td>
                        <td class="py-3 px-4 border-b border-gray-300">{{ $medida->waist }} cm</td>
                        <!-- Agrega más datos según sea necesario -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
