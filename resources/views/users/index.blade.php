

<x-admin-layout>
<div class="p-6 bg-gray-50 min-h-screen flex flex-col items-center ">
    <!-- Encabezado y filtro de búsqueda -->
    <div class="flex justify-between items-center w-full mb-4">
        <h2 class="text-2xl font-bold text-gray-700">Gestión de Usuarios</h2>
        <div class="relative">
            <input type="text" placeholder="Buscar usuarios..." class="w-64 p-2 pl-10 text-sm text-gray-600 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-blue-400" id="search">
            <span class="absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400">
                <i class="fas fa-search"></i> <!-- Icono de búsqueda -->
            </span>
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-lg w-full">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="py-3 px-6 text-left font-semibold text-gray-600">Nombre</th>
                    <th class="py-3 px-6 text-left font-semibold text-gray-600">Email</th>
                    <th class="py-3 px-6 text-left font-semibold text-gray-600">Fecha de Creación</th>
                    <th class="py-3 px-6 text-center font-semibold text-gray-600">Acciones</th>
                    <th class="py-3 px-6 text-center font-semibold text-gray-600">Estado</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($users as $user)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-all duration-200 ease-in-out">
                        <td class="py-4 px-6">{{ $user->name }}</td>
                        <td class="py-4 px-6">{{ $user->email }}</td>
                        <td class="py-4 px-6">{{ $user->created_at->format('d-m-Y') }}</td>
                        <td class="py-4 px-6 text-center flex justify-center space-x-4">
                            <!-- Botón para abrir el formulario de edición -->
                            <button onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')"
                                    class="text-blue-500 hover:text-blue-700 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
</svg>

                            </button>

                            <!-- Formulario de eliminación con confirmación personalizada -->
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="confirmDelete(event, {{ $user->id }})">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
</svg>

                                </button>
                            </form>
                        </td>
                        <!-- Columna separada para el switch -->
                        <td class="py-4 px-6 text-center">
                            <form action="{{ route('users.toggleStatus', $user->id) }}" method="POST">
                                @csrf
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only" {{ $user->is_active ? 'checked' : '' }} onchange="this.form.submit()">
                                    <div class="w-10 h-5 bg-gray-300 rounded-full shadow-inner flex items-center">
                                        <div class="{{ $user->is_active ? 'translate-x-5 bg-green-500' : 'translate-x-1 bg-gray-500' }} w-4 h-4 rounded-full transform transition-transform duration-200"></div>
                                    </div>
                                </label>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Paginación -->
        <div class="p-4 flex justify-center">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>
</div>
<!-- Modal de confirmación -->
<div id="confirmDeleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-semibold text-gray-700">¿Estás seguro?</h3>
        <p class="mt-2 text-gray-600">Esta acción no se puede deshacer.</p>
        <div class="mt-4 flex justify-end">
            <button id="cancelButton" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">Cancelar</button>
            <button id="confirmButton" class="ml-2 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">Eliminar</button>
        </div>
    </div>
</div>

    <!-- Modal de Edición -->
    <div id="editModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg relative">
            <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h2 class="text-xl font-bold text-gray-800 mb-4">{{ __('Editar Usuario') }}</h2>
            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-600">{{ __('Nombre') }}</label>
                    <input type="text" name="name" id="editName" class="w-full mt-1 border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-600">{{ __('Email') }}</label>
                    <input type="email" name="email" id="editEmail" class="w-full mt-1 border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 focus:outline-none">
                        {{ __('Cancelar') }}
                    </button>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 focus:outline-none">
                        {{ __('Actualizar Usuario') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript para gestionar el modal -->
    <script>
        function openEditModal(id, name, email) {
            // Configura el formulario con los datos del usuario
            document.getElementById('editForm').action = `/users/${id}`;
            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function confirmDelete(event, userId) {
    event.preventDefault(); // Evita el envío inmediato del formulario

    const modal = document.getElementById('confirmDeleteModal');
    const confirmButton = document.getElementById('confirmButton');
    const cancelButton = document.getElementById('cancelButton');

    modal.classList.remove('hidden'); // Muestra el modal

    // Cuando se hace clic en el botón de confirmación
    confirmButton.onclick = function() {
        const form = event.target.closest('form'); // Obtiene el formulario más cercano
        form.submit(); // Enviar el formulario
    };

    // Cuando se hace clic en el botón de cancelación
    cancelButton.onclick = function() {
        modal.classList.add('hidden'); // Oculta el modal
    };
}

        const switches = document.querySelectorAll('input[type="checkbox"]');
    switches.forEach(switchEl => {
        switchEl.addEventListener('change', function() {
            const dot = switchEl.nextElementSibling;
            if (this.checked) {
                dot.classList.add('translate-x-6');
                dot.classList.add('bg-green-500');
            } else {
                dot.classList.remove('translate-x-6');
                dot.classList.remove('bg-green-500');
            }
        });
    });
    document.getElementById('search').addEventListener('input', function (e) {
        const filter = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const name = row.children[0].textContent.toLowerCase();
            const email = row.children[1].textContent.toLowerCase();
            row.style.display = name.includes(filter) || email.includes(filter) ? '' : 'none';
        });
    });
    </script>
    <script src="https://unpkg.com/feather-icons"></script>

      @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/routines.js'])

</x-admin-layout>
