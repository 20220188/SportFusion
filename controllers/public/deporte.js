// Constante para completar la ruta de la API.
const DEPORTE_API = 'services/public/deporte.php';
// Constante para establecer el contenedor de categorías.
const CATEGORIAS = document.getElementById('categorias');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Deportes disponibles';
    // Petición para obtener las categorías disponibles.
    const DATA = await fetchData(DEPORTE_API, 'readAll');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se inicializa el contenedor de categorías.
        CATEGORIAS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se establece una palabra para el estado del producto.
            (row.estado_retro) ? estado = 'SI' : estado = 'NO';
            // Se establece la página web de destino con los parámetros.
            let url = `productos.html?id=${row.id_deporte}&nombre=${row.nombre_deporte}`;
            // Se crean y concatenan las tarjetas con los datos de cada categoría.
            CATEGORIAS.innerHTML += `
                <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card mb-3">
                    <a href="${url}">
                        <img src="${SERVER_URL}images/deportes/${row.imagen_deporte}" class="card-img-top" alt="${row.nombre_deporte}">
                    </a>
                    <div class="card-body text-center">
                        <h5 class="card-title">${row.nombre_deporte}</h5>
                        <p class="card-text">Retro: ${estado}</p>
                    </div>
                </div>
            </div>
            `;
        });
    } else {
        // Se asigna al título del contenido de la excepción cuando no existen datos para mostrar.
        document.getElementById('mainTitle').textContent = DATA.error;
    }
});