// Constantes para completar las rutas de la API de pedido.
const PEDIDO_API = 'services/public/pedido.php';
const CLIENTE_API = 'services/public/cliente.php';

// Constantes para completar las rutas de la API de DETALLE_PEDIDO.
const PRODUCTO_API = 'services/public/producto.php';
const VALORACION_API = 'services/public/valoracion.php';
/*
*Elementos para la tabla PEDIDOS | HISTORIAL DE COMPRAS
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
    FECHA_PEDIDO = document.getElementById('fechaPedido');

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
    PRECIO_DETALLE = document.getElementById('precioDetalle'),
    EXISTENCIAS_DETALLE = document.getElementById('existenciasDetalle')
    ESTADO_PEDIDO = document.getElementById('estadoPedido');
    ID_PEDIDO = document.getElementById('idPedido');

// Constante para guardar las valoraciones del cliente.

// Constantes para establecer el contenido de la tabla.
const TABLE_BODY_VALORACION = document.getElementById('tableBodyComentario'),
    ROWS_FOUND_VALORACION = document.getElementById('rowsFoundComentario');
// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL_VALORACION = new bootstrap.Modal('#saveModalComentario'),
    MODAL_TITLE_VALORACION = document.getElementById('modalTitleComentario');
// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM_VALORACION = document.getElementById('saveFormComentario'),

    COMENTARIO_VALORACION = document.getElementById('Comentario'),
    CALIFICACION_VALORACION = document.getElementById('Valoracion'),
    ID_DETALLEP = document.getElementById('idDetalle');
    ID_VALORACION = document.getElementById('idValoracion');



// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Historial de Compras';
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
    (form) ? action = 'searchRows' : action = 'readHistorial';
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(PEDIDO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY.innerHTML += `
                <tr>
                    <td>${row.id_pedido}</td>
                    <td>${row.fecha_registro}</td>
                    <td>${row.dirección_cliente}</td>
                    <td>${row.nombre_cliente}</td>
                    <td>${row.estado_pedido}</td>
                    <td>
                        <button type="button" class="btn btn-success" onclick="openDetails(${row.id_pedido})">
                        <i class="fa-regular fa-square-plus"></i>
                        </button>
                        <button type="button" class="btn btn-warning" onclick="openReport(${row.id_pedido})">
                        <i class="fa-regular fa-file-pdf"></i>
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
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
const fillTableDetails = async (id) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND_DETALLE.textContent = '';
    TABLE_BODY_DETALLE.innerHTML = '';
    // Se declara e inicializa una variable para calcular el importe por cada producto.
    let subtotal = 0;
    // Se declara e inicializa una variable para sumar cada subtotal y obtener el monto final a pagar.
    let total = 0;
    const FORM = new FormData();
    FORM.append('idPedido', id);
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(PEDIDO_API, 'readDetalleHistorial', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            subtotal = row.precio_pedido * row.cantidad_pedido;
            total += subtotal;
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY_DETALLE.innerHTML += `
                <tr>
                <td><img src="${SERVER_URL}images/productos/${row.imagen}" height="50"></td>
                    <td>${row.nombre_producto}</td>
                    <td>${row.precio_pedido}</td>
                    <td>${row.cantidad_pedido}</td>
                    <td>${subtotal.toFixed(2)}</td>
                    <td><button type="button" class="btn btn-warning" onclick="openComentario(${row.id_detalle})">
                        <i class="fa-regular fa-comment-dots"></i>
                        </button></td>
                </tr>
            `;
        });
        // Se muestra el total a pagar con dos decimales.
        document.getElementById('pago').textContent = total.toFixed(2);
        // Se muestra un mensaje de acuerdo con el resultado.
        ROWS_FOUND_DETALLE.textContent = DATA.message;
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

const openDetails = (id_pedido) => {
    console.log(id_pedido);
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL_DETALLE.show();
    MODAL_TITLE_DETALLE.textContent = 'Detalle de la compra';
    // Se prepara el formulario.
    SAVE_FORM_DETALLE.reset();


    fillTableDetails(id_pedido);
}

/*
* METODOS Y FUNCIONES PARA GESTIONAR LAS VALORACIONES
*/


// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM_VALORACION.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (ID_VALORACION.value) ? action = 'updateRowValoracion' : action = 'createRowValoracion';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM_VALORACION);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(VALORACION_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        //SAVE_MODAL_VALORACION.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTableValoracion(ID_DETALLEP.value);
    } else {
        sweetAlert(2, DATA.error, false);
    }
});


const fillTableValoracion = async (id) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND_VALORACION.textContent = '';
    TABLE_BODY_VALORACION.innerHTML = '';
    const FORM = new FormData();
    FORM.append('idDetalle', id);
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(VALORACION_API, 'readAllValoracionPublica', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY_VALORACION.innerHTML += `
                <tr>
                    <td>${converRatingToStars(row.valoracion)}</td>
                    <td>${row.comentario}</td>
                    <td><button type="button" class="btn btn-info" onclick="openUpdateComentario(${row.id_valoracion})">
                        <i class="fa-solid fa-pencil"></i>

                        <button type="button" class="btn btn-danger" onclick="openDelete(${row.id_valoracion})">
                        <i class="fa-regular fa-trash-can"></i>
                        </button>
                        </td>
                        
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
        ROWS_FOUND_VALORACION.textContent = DATA.message;
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

const converRatingToStars = (rating) => {
    let stars = '';
    for (let i = 0; i < 5; i++) {
        if (i < rating) {
            stars += '<i class="fas fa-star text-warning text-danger"></i>';
        } else {
            stars += '<i class="far fa-star text-warning text-danger"></i>';
        }
    }
    return stars
}


const openComentario = (id) => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL_VALORACION.show();
    MODAL_TITLE_VALORACION.textContent = 'Gestion de comentarios';
    // Se prepara el formulario.
    SAVE_FORM_VALORACION.reset();
    ID_DETALLEP.value = id;

    fillTableValoracion(id);
}

const openUpdateComentario = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idValoracion', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(VALORACION_API, 'readOneValoracion', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL_VALORACION.show();
        MODAL_TITLE_VALORACION.textContent = 'Actualizar comentario';
        // Se prepara el formulario.
        SAVE_FORM_VALORACION.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_VALORACION.value = ROW.id_valoracion;
        ID_DETALLEP.value = ROW.id_detalle;
        COMENTARIO_VALORACION.value = ROW.comentario;
        CALIFICACION_VALORACION.value = ROW.valoracion;
    } else {
        sweetAlert(2, DATA.error, false);
    }
}

const openDelete = async (id) => {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el comentario de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idValoracion', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(VALORACION_API, 'deleteRowValoracion', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se muestra un mensaje de éxito.
            await sweetAlert(1, DATA.message, true);
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTableValoracion();
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
const openReport = (id) => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/public/comprobante_compra.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}