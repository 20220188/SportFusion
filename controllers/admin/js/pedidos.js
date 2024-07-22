// Constantes para completar las rutas de la API de pedido.
const PEDIDO_API = 'services/admin/pedido.php';
const CLIENTE_API = 'services/admiin/clientes.php'

// Constantes para completar las rutas de la API de DETALLE_PEDIDO.
const PRODUCTO_API = 'services/admin/producto.php';
const ESTADO_PEDIDO_API = 'services/admin/estado_pedido.php';
/*
*Elementos para la tabla PEDIDOS
*/
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('searchForm');
// Constantes para establecer el contenido de la tabla.
const TABLE_BODY = document.getElementById('tableBody'),
    ROWS_FOUND = document.getElementById('rowsFound');
// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL = new bootstrap.Modal('#saveModal'),
    MODAL_TITLE = document.getElementById('modalTitle');
// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm'),
    DIRECCION_PEDIDO = document.getElementById('direccionPedido'),
    FECHA_PEDIDO = document.getElementById('fechaPedido')

/*
*Elementos para la tabla DETALLE_PEDIDO
*/

// Constantes para establecer el contenido de la tabla.
const TABLE_BODY_DETALLE = document.getElementById('tableBodyDetalle'),
    ROWS_FOUND_DETALLE = document.getElementById('rowsFoundDetalle');
// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL_DETALLE = new bootstrap.Modal('#saveModalDetalle'),
    MODAL_TITLE_DETALLE = document.getElementById('modalTitleDetalle');
// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM_DETALLE = document.getElementById('saveFormDetalle'),
    ID_DETALLEP = document.getElementById('idDetalle'),
    PRECIO_DETALLE = document.getElementById('precioDetalle'),
    EXISTENCIAS_DETALLE = document.getElementById('existenciasDetalle')
    ESTADO_PEDIDO = document.getElementById('estadoPedido');
    ID_PEDIDO = document.getElementById('idPedido')



// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Gestionar Pedidos';
    // Llamada a la función para llenar la tabla con los registros existentes.
    fillTable();
});

// Método del evento para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});


/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
const fillTable = async (form = null) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND.textContent = '';
    TABLE_BODY.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'searchRows' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(PEDIDO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY.innerHTML += `
                <tr>
                    <td>${row.dirección_cliente}</td>
                    <td>${row.fecha_registro}</td>
                    <td>${row.nombre_cliente}</td>
                    <td>${row.estado_pedido}</td>
                    <td>
                        <button type="button" class="btn btn-success" onclick="openDetails(${row.id_pedido},${row.id_estado_pedido})">
                        <i class="fa-regular fa-square-plus"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
        ROWS_FOUND.textContent = DATA.message;
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openCreate = () => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL.show();
    MODAL_TITLE.textContent = 'Crear pedido';
    // Se prepara el formulario.
    SAVE_FORM.reset();
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openUpdate = async (id) => {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idPedido', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(PEDIDO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'Actualizar pedido';
        // Se prepara el formulario.
        SAVE_FORM.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID.value = ROW.id_pedido;
        DIRECCION_PEDIDO.value = ROW.dirección_cliente;
        FECHA_PEDIDO.value = ROW.fecha_registro;
    } else {
        sweetAlert(2, DATA.error, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openDelete = async (id) => {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el pedido de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idPedido', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(PEDIDO_API, 'deleteRow', FORM);
        console.log(DATA);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se muestra un mensaje de éxito.
            await sweetAlert(1, DATA.message, true);
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
        } else {
            sweetAlert(2, DATA.error, false);
        }
    }
}


/*
*   Funciones para la tabla DETALLE_PEDIDO
*/

// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM_DETALLE.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (ID_PEDIDO.value) ? action = 'updateRow' : action = 'createRow';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM_DETALLE);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(PEDIDO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        SAVE_MODAL_DETALLE.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
const fillTableDetails = async (id) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND_DETALLE.textContent = '';
    TABLE_BODY_DETALLE.innerHTML = '';

    const FORM = new FormData();
    FORM.append('idPedido', id);
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(PEDIDO_API, 'readAllDetalle', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY_DETALLE.innerHTML += `
                <tr>
                    <td>${row.cantidad_pedido}</td>
                    <td>${row.precio_pedido}</td>
                    <td>${row.id_pedido}</td>
                    <td>${row.nombre_producto}</td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
        ROWS_FOUND_DETALLE.textContent = DATA.message;
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openDetails = (id_pedido,estado_pedido) => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL_DETALLE.show();
    MODAL_TITLE_DETALLE.textContent = 'Detalle producto';
    // Se prepara el formulario.
    SAVE_FORM_DETALLE.reset();
    
    ID_PEDIDO.value = id_pedido;
    fillSelect(ESTADO_PEDIDO_API, 'readAll', 'estadoPedido', estado_pedido);
    fillTableDetails(id_pedido);
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openUpdateDetails = async (id1) => {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM_DETALLE = new FormData();
    FORM_DETALLE.append('idDetalle', id1);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(PEDIDO_API, 'readOne', FORM_DETALLE);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL_DETALLE.show();
        MODAL_TITLE_DETALLE.textContent = 'Actualizar detalle de pedido';
        // Se prepara el formulario.
        SAVE_FORM_DETALLE.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_PEDIDO.value = ROW.id_pedido;
        fillSelect(ESTADO_PEDIDO_API, 'readAll', 'estadopedido', ROW.id_estado_pedido);


    } else {
        sweetAlert(2, DATA.error, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openDeleteDetails = async (id) => {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idDetalle', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(PEDIDO_API, 'deleteRowDetalle', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se muestra un mensaje de éxito.
            await sweetAlert(1, DATA.message, true);
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTableDetails();
        } else {
            sweetAlert(2, DATA.error, false);
        }
    }
}

/*
*   Función para abrir un reporte automático de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openReport = () => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/admin/pedidos_cliente.php`);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}