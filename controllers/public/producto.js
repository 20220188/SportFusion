// Constante para completar la ruta de la API.
const PRODUCTO_API = 'services/public/producto.php';
const CATEGORIA_API = 'services/public/categoria.php';
const CATEGORIA_CB = document.getElementById('categoria');
// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);
const PRODUCTOS = document.getElementById('productos');


// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se define un objeto con los datos de la categoría seleccionada.
    const FORM = new FormData();
    FORM.append('idDeporte', PARAMS.get('id'));
    // Petición para solicitar los productos de la categoría seleccionada.
    const DATA = await fetchData(PRODUCTO_API, 'readProductosDeporte', FORM);
    fillSelect(CATEGORIA_API, 'readAll', 'categoria');

    // Inicialmente muestra los productos de la categoría seleccionada en los parámetros de la URL
    loadProducts(null);

    // Agregar un event listener al combobox para manejar los cambios de selección
    CATEGORIA_CB.addEventListener('change', () => {
        const selectedValue = CATEGORIA_CB.options[CATEGORIA_CB.selectedIndex].value;
        loadProducts(selectedValue);
    });
});


// Función para cargar productos basados en la categoría seleccionada
async function loadProducts(selectedValue) {
    let data;
    const FORM = new FormData();
    
    if (selectedValue === null) {
        // Usar el idDeporte de los parámetros de la URL
        FORM.append('idDeporte', PARAMS.get('id'));
        data = await fetchData(PRODUCTO_API, 'readProductosDeporte', FORM);
    } else {
        // Usar la categoría seleccionada en el combobox
        FORM.append('idCategoria', selectedValue);
        FORM.append('idDeporte', PARAMS.get('id'));
        data = await fetchData(PRODUCTO_API, 'readProductoxCategoria', FORM);
    }

    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (data.status) {
        // Se asigna como título principal la categoría de los productos.
        MAIN_TITLE.textContent = `Deporte: ${PARAMS.get('nombre')}`;
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
                            <li class="list-group-item"><strong>Descripción:</strong> ${row.descripcion}</li>
                            <li class="list-group-item"><strong>Tipo de producto:</strong> ${row.tipo_producto}</li>
                        </ul>
                        <div class="card-body text-center">
                            <a href="detail.html?id=${row.id_producto}" class="btn btn-primary">Ver detalle</a>
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

    async function reloadProductosDeporte() {
        const FORM = new FormData();
        FORM.append('idDeporte', PARAMS.get('id'));
        await loadProducts(null);
    }
    
    // Agrega el event listener después de que el DOM se haya cargado
    document.addEventListener('DOMContentLoaded', () => {
        console.log('DOM fully loaded and parsed');
        // Agrega el event listener al botón
        document.getElementById('reloadButton').addEventListener('click', reloadProductosDeporte);
    });
}
