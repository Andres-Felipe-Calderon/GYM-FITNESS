import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', () => {
 



    // Manejar el envío del formulario para guardar la rutina
    const crearRutinaForm = document.getElementById('crearRutinaForm');
    crearRutinaForm.addEventListener('submit', async function (event) {
        event.preventDefault();

        const ejerciciosSeleccionados = obtenerEjerciciosSeleccionados();

        const formData = new FormData(crearRutinaForm);
        ejerciciosSeleccionados.forEach(ejercicio => {
            formData.append('ejercicios[]', ejercicio);
        });

        try {
            const response = await fetch('/routines', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            });

            if (!response.ok) {
                throw new Error('Error al guardar la rutina');
            }

            mostrarAlertaExito();
            crearRutinaForm.reset();
            document.getElementById('ejercicios').innerHTML = '';

        } catch (error) {
            console.error('Error:', error);
            mostrarAlertaError();
        }
    });

    // Funciones para mostrar y cerrar alertas
    function mostrarAlertaExito() {
        const alertaExito = document.getElementById('alerta-exito');
        alertaExito.classList.remove('hidden');
        setTimeout(() => {
            alertaExito.classList.add('hidden');
        }, 5000);
    }

    function mostrarAlertaError() {
        const alertaError = document.getElementById('alerta-error');
        alertaError.classList.remove('hidden');
        setTimeout(() => {
            alertaError.classList.add('hidden');
        }, 5000);
    }

    // Funciones para cerrar las alertas manualmente
    document.getElementById('cerrarAlertaExito').addEventListener('click', function () {
        document.getElementById('alerta-exito').classList.add('hidden');
    });

    document.getElementById('cerrarAlertaError').addEventListener('click', function () {
        document.getElementById('alerta-error').classList.add('hidden');
    });







});

// Esperar a que el DOM esté completamente cargado



// Asocia el evento de clic al botón de obtener ejercicios

document.addEventListener('DOMContentLoaded', () => {
    const obtenerEjerciciosBtn = document.getElementById('obtenerEjercicios');

    if (obtenerEjerciciosBtn) {
        obtenerEjerciciosBtn.addEventListener('click', obtenerEjercicios);
    }

    async function obtenerEjercicios() {
        const parte = document.getElementById('parte').value; // Asegúrate de que 'parte' exista en el DOM
        const ejerciciosDiv = document.getElementById('ejercicios');

        // Verifica que el div de ejercicios exista
        if (!ejerciciosDiv) {
            console.error('El div de ejercicios no se encuentra en el DOM.');
            return;
        }

        // Limpia el div de ejercicios antes de cargar nuevos
        ejerciciosDiv.innerHTML = '';

        console.log('Parte seleccionada:', parte);

        if (parte) {
            try {
                const apiUrl = `/ejercicios/${parte}`;
                console.log('URL solicitada:', apiUrl);

                const response = await fetch(apiUrl, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                // Verifica que haya ejercicios
                if (data.length) {
                    data.forEach(ejercicio => {
                        const ejercicioDiv = document.createElement('div');
                        ejercicioDiv.classList.add('border', 'p-4', 'rounded', 'shadow', 'mb-2');

                        // Construir la URL del GIF usando el exercise_id
                        const gifPath = `/gifs/${ejercicio.exercise_id}.gif`;

                        // Crear un checkbox para seleccionar el ejercicio
                        ejercicioDiv.innerHTML = `
                            <input type="checkbox" id="${ejercicio.id}" value="${ejercicio.name}">
                            <label for="${ejercicio.id}">${ejercicio.name}</label>
                            <br>
                            <img src="${gifPath}" alt="${ejercicio.name}" class="exercise-animation">
                        `;

                        ejerciciosDiv.appendChild(ejercicioDiv);
                    });
                } else {
                    ejerciciosDiv.innerHTML = '<p class="text-gray-600">No se encontraron ejercicios para esta parte del cuerpo.</p>';
                }
            } catch (error) {
                console.error('Error al obtener ejercicios:', error);
                ejerciciosDiv.innerHTML = '<p class="text-red-600">Error al obtener ejercicios.</p>';
            }
        } else {
            ejerciciosDiv.innerHTML = '<p class="text-gray-600">Por favor, selecciona una parte del cuerpo.</p>';
        }
    }
});


// Función para capturar los ejercicios seleccionados
function obtenerEjerciciosSeleccionados() {
    const checkboxes = document.querySelectorAll('#ejercicios input[type="checkbox"]:checked');
    const ejerciciosSeleccionados = Array.from(checkboxes).map(checkbox => checkbox.value);

    console.log('Ejercicios seleccionados:', ejerciciosSeleccionados);
    return ejerciciosSeleccionados; // Retorna la lista de ejercicios seleccionados
}
document.addEventListener('DOMContentLoaded', () => {
    obtenerRutinas(); // Llamar a la función que obtiene las rutinas cuando la página carga

    // Función para obtener las rutinas y mostrarlas en la tabla
    async function obtenerRutinas() {
        try {
            const response = await fetch('/api/routines', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Agregar el token CSRF si es necesario
                }
            });

            if (!response.ok) {
                throw new Error('Error al obtener las rutinas');
            }

            const data = await response.json(); // Obtén las rutinas en formato JSON
            console.log('Datos obtenidos de la persona autenticada:', data); // Muestra el resultado en la consola
            mostrarRutinasEnTabla(data); // Muestra las rutinas en la tabla
        } catch (error) {
            console.error('Error:', error);
        }
    }

    function mostrarRutinasEnTabla(rutinas) {
        const tablaBody = document.querySelector('tbody');
        
        // Limpia el tbody antes de insertar nuevas filas
        tablaBody.innerHTML = ''; 
    
        // Muestra el loader
        mostrarSkeletonLoader(tablaBody);
    
        // Simula una solicitud de red (remover en producción)
        setTimeout(() => {
            // Limpia el tbody
            tablaBody.innerHTML = ''; 
    
            // Si no hay rutinas, simplemente no hacemos nada
            if (!rutinas || rutinas.length === 0) {
                return; // No hay rutinas que mostrar
            }
    
            // Itera sobre las rutinas y crea filas dinámicamente
            rutinas.forEach(rutina => {
                const fila = document.createElement('tr');
                fila.classList.add('hover:bg-gray-100'); 
                fila.setAttribute('id', `fila-${rutina.id}`); // Agregar ID para facilitar eliminación de fila en el DOM
    
                fila.innerHTML = `
                <td class="border px-4 py-2 text-center">${rutina.nombre}</td>
                <td class="border px-4 py-2 text-center">${rutina.descripcion}</td>
                <td class="border px-4 py-2">
                    <div class="flex justify-center">
                        <div class="relative">
                            <button class="flex items-center h-8 p-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors" id="menu-btn-${rutina.id}">
                                <i class="fas fa-ellipsis-v text-gray-400"></i>
                            </button>
                            <div class="hidden absolute top-auto right-0 -mt-4 -mr-4 w-48 bg-white border border-gray-200 shadow-lg z-50 menu" id="menu-${rutina.id}">
                                <a href="/routines/${rutina.id}/edit" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Editar</a>
                                <button class="eliminar-btn w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100" data-id="${rutina.id}">
                                    Eliminar
                                </button>
                                <button class="detalles-btn w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100" data-id="${rutina.id}">
                                    Detalles
                                </button>
                                <button class="asignar-btn w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100" data-id="${rutina.id}">
                                    Asignar
                                </button>
                            </div>
                        </div>
                    </div>
                </td>
            `;
            
                
                // Agregar la fila al cuerpo de la tabla
                tablaBody.appendChild(fila);
            });
    
        // Asigna el evento click a los botones de "Detalles" para abrir el modal
        document.querySelectorAll('.detalles-btn').forEach(button => {
            button.addEventListener('click', function () {
                const rutinaId = this.getAttribute('data-id');
                abrirModal(rutinaId);
            });
        });
    
        // Añadir evento para mostrar/ocultar el menú
       document.querySelectorAll('[id^="menu-btn-"]').forEach(button => {
    button.addEventListener('click', function (event) {
        const id = this.id.split('-')[2]; // Extrae el id de la rutina
        const menu = document.getElementById(`menu-${id}`);
        const isMenuVisible = !menu.classList.toggle('hidden'); // Alterna la visibilidad del menú

        if (isMenuVisible) {
            // Agregar event listeners a las opciones del menú solo cuando se muestra
            const opcionesMenu = menu.querySelectorAll('a, button'); // Selecciona enlaces y botones
            opcionesMenu.forEach(opcion => {
                opcion.addEventListener('click', function () {
                    menu.classList.add('hidden'); // Oculta el menú al hacer clic en una opción
                });
            });
        }

        event.stopPropagation(); // Evita que el clic se propague y cierre el menú inmediatamente
    });
});



    tablaBody.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('eliminar-btn')) {
            const rutinaId = e.target.getAttribute('data-id');
            console.log("ID de la rutina a eliminar:", rutinaId);

            if (rutinaId) {
                confirmarEliminacion(rutinaId);
            }
        }
    });


function confirmarEliminacion(rutinaId) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/routines/${rutinaId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire(
                    'Eliminado',
                    data.message,
                    'success'
                );

                // Remueve la fila del DOM
                const fila = document.getElementById(`fila-${rutinaId}`);
                if (fila) {
                    fila.remove();
                }
            })
            .catch(error => {
                console.error('Error al eliminar:', error);
                Swal.fire(
                    'Error',
                    'Hubo un problema al intentar eliminar la rutina.',
                    'error'
                );
            });
        }
    });
}


    // Inserta este código JavaScript al final de tu archivo o en una sección de <script>

// Inserta este código JavaScript en tu archivo principal o en un script dentro de tu vista


        // Asigna un evento a cada botón que tiene la clase 'asignar-btn'
        document.querySelectorAll('.asignar-btn').forEach(button => {
            button.addEventListener('click', () => {
                const routineId = button.getAttribute('data-id');
                document.getElementById('routine_id').value = routineId; // Asignar el ID de la rutina al campo oculto
                document.getElementById('asignarModal').classList.remove('hidden'); // Mostrar el modal
            });
        });
    
        // Cerrar modal
        document.getElementById('closeModal1').addEventListener('click', () => {
            document.getElementById('asignarModal').classList.add('hidden'); // Oculta la modal
        });
    
        // Cerrar el menú al hacer clic fuera de él
        document.addEventListener('click', function (event) {
            if (!event.target.closest('.relative')) {
                document.querySelectorAll('.absolute').forEach(menu => {
                    menu.classList.add('hidden'); // Oculta todos los menús
                });
            }
        });
    }, 2000);
    }
    
    function mostrarSkeletonLoader(tablaBody) {
        // Crear filas de skeleton
        for (let i = 0; i < 3; i++) { // Muestra 3 filas de skeleton
            const filaSkeleton = document.createElement('tr');
            filaSkeleton.innerHTML = `
                <td class="border px-4 py-2">
                    <div class="animate-pulse bg-gray-200 h-4 w-full rounded"></div>
                </td>
                <td class="border px-4 py-2">
                    <div class="animate-pulse bg-gray-200 h-4 w-full rounded"></div>
                </td>
                <td class="border px-4 py-2">
                    <div class="animate-pulse bg-gray-200 h-4 w-full rounded"></div>
                </td>
            `;
            tablaBody.appendChild(filaSkeleton);
        }
    }
    
    document.getElementById('asignarForm').addEventListener('submit', async (event) => {
        event.preventDefault(); // Evita que se envíe el formulario de la manera convencional

        const formData = new FormData(event.target);

        try {
            const response = await fetch(`/routines/assign/${formData.get('routine_id')}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json' // Asegúrate de que el servidor devuelva JSON
                }
            });

            if (response.ok) {
                const result = await response.json(); // Captura la respuesta JSON
                alert(result.message || 'Rutina asignada correctamente.'); // Mensaje de éxito
                document.getElementById('asignarModal').classList.add('hidden'); // Ocultar modal
                // Opcional: Actualizar la vista o la tabla de rutinas aquí
            } else {
                const errorData = await response.json(); // Captura los errores
                alert(errorData.error || 'Error al asignar la rutina.'); // Mensaje de error
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Hubo un problema al asignar la rutina.');
        }
    });

    function abrirModal(rutinaId) {
        console.log(`Abrir modal para la rutina ID: ${rutinaId}`);
    
        // Crea el skeleton loader y añádelo al modalContent
        const modalContent = document.getElementById('modalContent');
        if (!modalContent) {
            console.error('Contenido del modal no encontrado en el DOM');
            return;
        }
    
        // Limpia el contenido anterior y muestra el skeleton loader
        modalContent.innerHTML = ''; // Limpia el contenido anterior
    
        const skeletonLoader = document.createElement('div');
        skeletonLoader.className = 'skeleton-loader'; // Asegúrate de definir el estilo para este loader
        skeletonLoader.innerHTML = `
            <div class="skeleton-title"></div>
            <div class="skeleton-description"></div>
            <div class="skeleton-exercises"></div>
        `;
        modalContent.appendChild(skeletonLoader); // Añade el skeleton al modalContent
    
        // Llama al endpoint para obtener todas las rutinas
        fetch(`/api/routines/`)
            .then(response => {
                if (!response.ok) {
                    console.error('Error en la respuesta de la API:', response);
                    throw new Error('Error en la respuesta de la API: ' + response.statusText);
                }
                return response.json();
            })
            .then(rutinas => {
                const rutina = rutinas.find(r => r.id === Number(rutinaId));
                if (!rutina) throw new Error('Rutina no encontrada');
    
                // Cargar todos los ejercicios en una sola llamada
                const ejercicios = JSON.parse(rutina.ejercicios);
                return Promise.all(ejercicios.map(ejercicio => cargarEjercicio(ejercicio.trim())));
            })
            .then(ejerciciosData => {
                // Aquí reemplaza el contenido del modal con los datos cargados
                modalContent.innerHTML = `
                    <h4>Ejercicios:</h4>
                    <ul id="lista-ejercicios">
                        ${ejerciciosData.map(data => `
                            <li>
                                <strong>${data.name}</strong> 
                                <img src="/gifs/${data.exercise_id}.gif" alt="${data.name}" style="width: 100px; height: auto;">
                            </li>
                        `).join('')}
                    </ul>
                `;
    
                // Elimina el skeleton loader
                skeletonLoader.remove(); // Elimina el skeleton loader
            })
            .catch(error => {
                console.error('Error al obtener los datos de la rutina:', error);
                alert('No se pudo cargar la información de la rutina.');
                skeletonLoader.remove(); // Asegúrate de quitar el loader si hay un error
            });
    
        // Muestra el modal
        const modal = document.getElementById('detailsModal');
        if (!modal) {
            console.error('Modal no encontrado en el DOM');
            return;
        }
        modal.classList.remove('hidden');
    }
    
    // Función para cargar un único ejercicio
    async function cargarEjercicio(ejercicioNombre) {
        try {
            const ejercicioNombreEncoded = encodeURIComponent(ejercicioNombre); // Asegúrate de eliminar espacios innecesarios
            const response = await fetch(`/ejercicios/nombre/${ejercicioNombreEncoded}`);
            
            if (!response.ok) {
                throw new Error('Error al obtener los datos del ejercicio');
            }
    
            const data = await response.json();
            return data; // Devuelve los datos del ejercicio
        } catch (error) {
            console.error('Error al obtener los datos del ejercicio:', error);
            return { name: ejercicioNombre, exercise_id: 'default' }; // Devuelve un objeto con un valor por defecto en caso de error
        }
    }
    
    
    
    // Cierra el modal
    document.getElementById('closeModal').addEventListener('click', function() {
        const modal = document.getElementById('detailsModal');
        if (modal) {
            modal.classList.add('hidden'); // Oculta el modal
        }
    });


    // Obtiene el token CSRF desde la meta etiqueta
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Escucha el evento de clic en el botón para ver el calendario
    document.getElementById('verCalendario').addEventListener('click', function () {
        console.log('Botón "Ver Calendario" clicado'); // Log cuando el botón es clicado
        abrirCalendario();
    });

    function abrirCalendario() {
        const calendarModal = document.getElementById('calendarModal');
        calendarModal.classList.remove('hidden'); // Muestra el modal
        console.log('Modal de calendario abierto'); // Log cuando se abre el modal

        const calendarEl = document.getElementById('calendar');
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, interactionPlugin],
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'timeGridWeek,timeGridDay'
            },
            editable: true,
            events: function (fetchInfo, successCallback, failureCallback) {
                console.log('Obteniendo eventos para el calendario...'); // Log antes de la solicitud de eventos
                fetch('/myAssignments', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken, // Añade el token CSRF para la protección
                        'Content-Type': 'application/json' // Indica que el contenido es JSON
                    }
                })

                    .then(response => {
                        console.log('Respuesta recibida de /my-assignments:', response); // Log de la respuesta
                        if (!response.ok) {
                            throw new Error('Error al obtener rutinas asignadas');
                        }
                        return response.json(); // Convierte la respuesta a JSON
                    })
                    .then(data => {
                        console.log('Datos de rutinas asignadas:', data); // Log de los datos obtenidos
                        successCallback(data); // Proporciona los datos al calendario
                    })
                    .catch(error => {
                        console.error('Error al cargar las rutinas:', error); // Log del error
                        failureCallback(error); // Llama al callback de error si ocurre un problema
                    });
            },
        });

        calendar.render(); // Renderiza el calendario en el modal
        console.log('Calendario renderizado'); // Log cuando el calendario se renderiza
    }




    // Cerrar el modal al hacer clic en el botón de cerrar
    document.getElementById('closeCalendarModal').addEventListener('click', function () {
        const calendarModal = document.getElementById('calendarModal');
        calendarModal.classList.add('hidden'); // Oculta el modal
    });


});

/*
async function descargarGifsPorTargets(targets) {
    for (const musculo of targets) {
        try {
            const response = await fetch(`https://exercisedb.p.rapidapi.com/exercises/target/${musculo}?limit=10&offset=0`, {
                method: 'GET',
                headers: {
                    'x-rapidapi-host': 'exercisedb.p.rapidapi.com',
                    'x-rapidapi-key': '7aa44562c7mshe067078f1a52acdp1e9004jsnee597cd6a3eb', // Reemplaza con tu clave API
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`Error al obtener ejercicios para ${musculo}: ${response.status}`);
            }

            const ejercicios = await response.json();

            for (const ejercicio of ejercicios) {
                await guardarGif(ejercicio.gifUrl, ejercicio.id);
            }

        } catch (error) {
            console.error(error);
        }
    }
}

async function guardarGif(gifUrl, id) {
    try {
        const response = await fetch('/download-gif', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ gifUrl, id })
        });

        if (!response.ok) {
            throw new Error(`Error al guardar el GIF con ID ${id}`);
        }

        console.log(`GIF guardado para el ejercicio ID: ${id}`);
    } catch (error) {
        console.error(error);
    }
}
// Ejemplo de uso con el arreglo de targets
const targets = [
    "upper back"
];

// Llama a la función para descargar GIFs
descargarGifsPorTargets(targets);
*/
document.addEventListener('DOMContentLoaded', function () {
    // Asignar el evento 'click' a cada área de músculo
    document.querySelectorAll('.muscle').forEach(element => {
        element.addEventListener('click', function () {
            const musculo = this.getAttribute('data-muscle');
            mostrarEjercicios(musculo);
        });
    });
});

function mostrarEjercicios(musculo) {
    // Obtener los elementos del DOM
    const loadingMessage = document.getElementById('loading-message');
    const ejerciciosContainer = document.getElementById('ejercicios');
    const spinner = document.getElementById('spinner');

    // Limpiar el contenedor de ejercicios antes de cargar los nuevos
    while (ejerciciosContainer.firstChild) {
        ejerciciosContainer.removeChild(ejerciciosContainer.firstChild);
    }

    // Mostrar el skeleton loader
    for (let i = 0; i < 3; i++) { // Muestra 3 skeletons como ejemplo
        const skeletonCard = document.createElement('div');
        skeletonCard.className = 'skeleton-card';
        skeletonCard.innerHTML = `
            <div class="skeleton-title"></div>
            <div class="skeleton-image"></div>
            <div class="skeleton-line"></div>
            <div class="skeleton-line"></div>
        `;
        ejerciciosContainer.appendChild(skeletonCard);
    }

    // Mostrar el spinner y mensaje de carga
    spinner.style.display = 'flex';
    loadingMessage.style.display = 'block';

    // Llamada a la API para obtener ejercicios según el músculo
    fetch(`/ejercicios/${musculo}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los ejercicios');
            }
            return response.json();
        })
        .then(ejercicios => {
            // Ocultar skeleton loader y spinner
            spinner.style.display = 'none';
            loadingMessage.style.display = 'none';
            while (ejerciciosContainer.firstChild) {
                ejerciciosContainer.removeChild(ejerciciosContainer.firstChild);
            }

            if (ejercicios.length > 0) {
                // Renderiza los ejercicios reales
                ejercicios.forEach(ejercicio => {
                    const ejercicioCard = document.createElement('div');
                    ejercicioCard.className = 'p-4 bg-white rounded-lg shadow-md transition-transform duration-200 transform hover:scale-105';

                    const gifPath = `/gifs/${ejercicio.exercise_id}.gif`;

                    ejercicioCard.innerHTML = `
                        <h3 class="font-bold text-lg mb-2 text-gray-800 text-center">${ejercicio.name}</h3>
                        <img src="${gifPath}" alt="${ejercicio.name}" class="w-full h-auto rounded-md mb-3">
                        <p class="text-gray-600"><strong>Target:</strong> ${ejercicio.target}</p>
                        <p class="text-gray-600"><strong>Equipamiento:</strong> ${ejercicio.equipment}</p>
                    `;

                    ejerciciosContainer.appendChild(ejercicioCard);
                });
            } else {
                // Mostrar mensaje de que no hay ejercicios
                const noEjerciciosElement = document.createElement('div');
                noEjerciciosElement.className = 'p-4 text-gray-600';
                noEjerciciosElement.innerText = 'No hay ejercicios disponibles para este músculo.';
                ejerciciosContainer.appendChild(noEjerciciosElement);
            }
        })
        .catch(error => {
            console.error(error);
            spinner.style.display = 'none';
            loadingMessage.style.display = 'none';
            while (ejerciciosContainer.firstChild) {
                ejerciciosContainer.removeChild(ejerciciosContainer.firstChild);
            }

            // Mostrar mensaje de error
            const errorElement = document.createElement('div');
            errorElement.className = 'p-4 text-red-600';
            errorElement.innerText = 'Hubo un error al cargar los ejercicios.';
            ejerciciosContainer.appendChild(errorElement);
        });
}
