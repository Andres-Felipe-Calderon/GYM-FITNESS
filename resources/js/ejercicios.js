// Diccionario básico para traducir términos al español
const diccionario = {
    "back": "Espalda",
    "chest": "Pecho",
    "upper arms": "Brazos superiores",
    "lower arms": "Brazos inferiores",
    "upper legs": "Piernas superiores",
    "lower legs": "Piernas inferiores",
    "waist": "Cintura",
    "neck": "Cuello",
    "shoulders": "Hombros",
    "cardio": "Cardio",
    "equipment": "Equipo",
    "target": "Objetivo",
    "bodypart": "Parte del cuerpo",
};

// Cache de traducciones
const translationCache = {};

// Función para traducir términos usando el diccionario y caché
function traducir(texto) {
    texto = texto.toLowerCase();
    if (translationCache[texto]) {
        return translationCache[texto];
    }
    const traduccion = diccionario[texto] || texto;
    translationCache[texto] = traduccion;
    return traduccion;
}

// Función para traducir instrucciones
function traducirInstrucciones(instrucciones) {
    return instrucciones.split('. ').map(instruccion => traducir(instruccion)).join('. ');
}

// Función para traducir textos a través de la API
const translateTexts = async (texts) => {
    const uniqueTexts = [...new Set(texts)]; // Eliminar duplicados
    try {
        const response = await fetch('/google-translate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ texts: uniqueTexts }), // Envío de textos como un array
        });

        if (!response.ok) throw new Error('Error de red');

        const data = await response.json();
        // Guardar traducciones en caché
        uniqueTexts.forEach((text, index) => {
            translationCache[text] = data.translatedTexts[index];
        });

        // Retornar las traducciones en el mismo orden
        return texts.map(text => translationCache[text]);
    } catch (error) {
        console.error('Error en la traducción por lotes:', error);
        return texts; // Retorna los textos originales en caso de error
    }
};

const ejerciciosCache = {}; // Objeto para almacenar ejercicios en caché

async function mostrarEjercicios(parte) {
    // Mostrar el spinner en lugar del mensaje de carga
    document.getElementById('ejercicios').innerHTML = `
        <div class="flex justify-center items-center min-h-[200px]">
            <div class="loader"></div> <!-- Spinner -->
        </div>
    `;

    // Verificar si ya tenemos los ejercicios en caché
    if (ejerciciosCache[parte]) {
        mostrarEjerciciosDesdeCache(ejerciciosCache[parte], parte); // Pasar parte como argumento
        return;
    }

    try {
        const response = await fetch(`/ejercicios?parte=${parte}`, {
            method: "GET",
            headers: { "Accept": "application/json" }
        });

        if (!response.ok) throw new Error(`Error: ${response.status} - ${response.statusText}`);

        const data = await response.json();

        if (data.length === 0) {
            document.getElementById('ejercicios').innerHTML = `<h2 class="text-center text-gray-600">No se encontraron ejercicios para ${parte}.</h2>`;
            return;
        }

        // Almacenar en caché
        ejerciciosCache[parte] = data;

        // Mostrar ejercicios
        mostrarEjerciciosDesdeCache(data, parte); // Pasar parte como argumento

    } catch (error) {
        console.error('Error al obtener los ejercicios:', error);
        document.getElementById('ejercicios').innerHTML = `<h2 class="text-center text-red-600">Error al cargar los ejercicios. Intenta de nuevo más tarde.</h2>`;
    }
}


function mostrarEjerciciosDesdeCache(data, parte) { // Recibir parte como argumento
    // Preparar los textos a traducir
    const nombresEjercicios = data.map(ej => ej.name);
    
    // Llamada a la API de traducción en lote
    translateTexts(nombresEjercicios).then(traducciones => {
        const ejerciciosHTML = data.map((ej, index) => `
            <div class="card p-4 border rounded shadow-lg" onclick="mostrarDetalleEjercicio('${ej.id}', '${parte}')">
                <h3 class="text-lg font-semibold">${traducciones[index]}</h3>
                <div class="animacion">
                    <img src="${ej.gifUrl}" alt="${ej.name}" class="w-full h-auto">
                </div>
            </div>
        `).join('');
    
        document.getElementById('ejercicios').innerHTML = ejerciciosHTML;
    });
}

// Función para mostrar detalles del ejercicio
async function mostrarDetalleEjercicio(id, parte) {
    try {
        const response = await fetch(`https://exercisedb.p.rapidapi.com/exercises/exercise/${id}`, {
            method: "GET",
            headers: {
                "x-rapidapi-host": "exercisedb.p.rapidapi.com",
                "x-rapidapi-key": "43d5ad9f6fmshc2c018a26a070a6p108bfbjsndc673c100a7e"
            }
        });

        if (!response.ok) {
            throw new Error(`Error: ${response.status} - ${response.statusText}`);
        }

        const ejercicio = await response.json();

        const instrucciones = Array.isArray(ejercicio.instructions) ? 
            ejercicio.instructions : 
            (ejercicio.instructions ? [ejercicio.instructions] : []);

        // Preparar los textos a traducir
        const textosATraducir = [
            ejercicio.name,
            ejercicio.bodyPart,
            ejercicio.equipment,
            ejercicio.target,
            ...instrucciones
        ];

        // Llamada a la API de traducción en lote
        const traducciones = await translateTexts(textosATraducir);

        // Mostrar los detalles del ejercicio
        const ejercicioDetalleHTML = `
            <div class="flex flex-col md:flex-row p-4 border rounded shadow-lg">
                <div class="md:w-1/2">
                    <img src="${ejercicio.gifUrl}" alt="${ejercicio.name}" class="w-full h-auto">
                </div>
                <div class="md:w-1/2 md:pl-4">
                    <h3 class="text-lg font-semibold">${traducciones[0]}</h3>
                    <p><strong>Parte del cuerpo:</strong> ${traducciones[1]}</p>
                    <p><strong>Equipo:</strong> ${traducciones[2]}</p>
                    <p><strong>Objetivo:</strong> ${traducciones[3]}</p>
                    <h4 class="mt-4 text-lg font-semibold">Instrucciones:</h4>
                    <ul>
                        ${traducciones.slice(4).length > 0 ? traducciones.slice(4).map(instruction => `<li>${instruction}</li>`).join('') : 'No disponible.'}
                    </ul>
                    <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded" onclick="mostrarEjercicios('${parte}')">${traducir("Regresar")}</button>
                </div>
            </div>
        `;

        document.getElementById('ejercicios').innerHTML = ejercicioDetalleHTML;
    } catch (error) {
        console.error('Error al obtener el detalle del ejercicio:', error);
        document.getElementById('ejercicios').innerHTML = `<h2>Error al cargar los detalles del ejercicio. Intenta de nuevo más tarde.</h2>`;
    }
}

// Asegúrate de que las funciones sean globales
window.mostrarEjercicios = mostrarEjercicios;
window.mostrarDetalleEjercicio = mostrarDetalleEjercicio;

// Asegúrate de que el script se ejecute después de que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', () => {
    // Inicializa o llama a funciones aquí si es necesario
});
