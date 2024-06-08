// Constante para completar la ruta de la API.
const PRODUCTO_API = 'services/public/producto.php';
const CATEGORIA_API = 'services/public/categoria.php';
const TIPO_PRODUCTO_API = 'services/public/tipo_producto.php';
const GENERO_API = 'services/public/genero.php';
const DEPORTE_API = 'services/public/deporte.php';

const CATEGORIA_CB = document.getElementById('categoria');
const TIPO_PRODUCTO_CB = document.getElementById('tipoProducto');
const GENERO_CB = document.getElementById('genero');
const DEPORTE_CB = document.getElementById('deporte');
// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
const PRODUCTOS = document.getElementById('productos');


// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se define un objeto con los datos de la categoría seleccionada.
    const FORM = new FormData();
    // Petición para solicitar los productos de la categoría seleccionada.
    const DATA = await fetchData(PRODUCTO_API, 'readProductos', FORM);
    fillSelect(CATEGORIA_API, 'readAll', 'categoria');
    fillSelect(TIPO_PRODUCTO_API, 'readAll_TipoP', 'tipoProducto');
    fillSelect(GENERO_API, 'readAll', 'genero');
    fillSelect(DEPORTE_API, 'readAll', 'deporte');

    // Inicialmente muestra los productos de la categoría seleccionada en los parámetros de la URL
    loadProducts();

    // Agregar un event listener al combobox para manejar los cambios de selección
    
});

CATEGORIA_CB.addEventListener('change', () => {
    loadProducts();
});

TIPO_PRODUCTO_CB.addEventListener('change', () => {
    loadProducts();
});

GENERO_CB.addEventListener('change', () => {
    loadProducts();
});

DEPORTE_CB.addEventListener('change', () => {
    loadProducts();
});

// Función para cargar productos basados en la categoría seleccionada
async function loadProducts() {
    const FORM = new FormData();
    if (CATEGORIA_CB.value) {
        // Usar el idDeporte de los parámetros de la URL
        FORM.append('idCategoria', CATEGORIA_CB.value);
    }
    if (TIPO_PRODUCTO_CB.value) {
        FORM.append('idTipoProducto', TIPO_PRODUCTO_CB.value);
    }
    if (GENERO_CB.value) {
        FORM.append('idGenero', GENERO_CB.value);
    }
    if (DEPORTE_CB.value) {
        FORM.append('idDeporte', DEPORTE_CB.value);
    }
    const data = await fetchData(PRODUCTO_API, 'readProductos', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (data.status) {
        // Se asigna como título principal la categoría de los productos.
        MAIN_TITLE.textContent = ``;
        // Se inicializa el contenedor de productos.
        PRODUCTOS.innerHTML = '';
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        data.dataset.forEach(row => {
            // Se crean y concatenan las tarjetas con los datos de cada producto.
            PRODUCTOS.innerHTML += `
                <div class="col-sm-12 col-md-6 col-lg-3">
                    <div class="card mb-3">
                        <img src="${SERVER_URL}images/productos/${row.imagen}" class="card-img-top" alt="${row.nombre_producto}">
                        <div class="card-body">
                            <h5 class="card-title">${row.nombre_producto}</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Tipo de producto:</strong> ${row.tipo_producto}</li>
                            <li class="list-group-item"><strong>Genero:</strong> ${row.genero}</li>
                        </ul>
                        <div class="card-body text-center">
                            <a href="detalle_producto.html?id=${row.id_producto}" class="btn btn-primary">Ver detalle</a>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        MAIN_TITLE.textContent = data.error;
    }

    //Funcion para volver a cargar la vista general de los productos

}
