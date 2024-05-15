// Constantes para completar las rutas de la API de PRODUCTO.
const PRODUCTO_API = 'services/admin/producto.php';
const CATEGORIA_API = 'services/admin/categoria.php';
const TIPO_PRODUCTO_API = 'services/admin/tipo_producto.php';
const DEPORTE_API = 'services/admin/deporte.php';

// Constantes para completar las rutas de la API de DETALLE_PRODUCTO.
const GENERO_API = 'services/admin/genero.php';
const TALLA_API = 'services/admin/talla.php';
/*
*Elementos para la tabla PRODUCTOS
*/

const TIPOP_API = 'services/admin/tipo_producto.php';
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
    ID_PRODUCTO = document.getElementById('idProducto'),
    NOMBRE_PRODUCTO = document.getElementById('nombreProducto'),
    DESCRIPCION_PRODUCTO = document.getElementById('descripcionProducto')

/*
*Elementos para la tabla DETALLE_PRODUCTO
*/

// Constantes para establecer el contenido de la tabla.
const TABLE_BODY_DETALLE = document.getElementById('tableBodyDetalle'),
    ROWS_FOUND_DETALLE = document.getElementById('rowsFoundDetalle');
// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL_DETALLE = new bootstrap.Modal('#saveModalDetalle'),
    MODAL_TITLE_DETALLE = document.getElementById('modalTitleDetalle');
// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM_DETALLE = document.getElementById('saveFormDetalle'),
    ID_DETALLE = document.getElementById('idDetalle'),
    PRECIO_DETALLE = document.getElementById('precioDetalle'),
    EXISTENCIAS_DETALLE = document.getElementById('existenciasDetalle')
    ID_PRODUCTO_DETALLE = document.getElementById('idProductoDetalle');

/*
*Elementos para la tabla TIPO_PRODUCTO
*/
// Constante para establecer el formulario de buscar.
// Constantes para establecer los elementos de la tabla.
const TABLE_BODY_TIPOP = document.getElementById('tableBodyTipoP'),
    ROWS_FOUND_TIPOP = document.getElementById('rowsFoundTipoP');
// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL_TIPOP = new bootstrap.Modal('#saveModalTipoP'),
    MODAL_TITLE_TIPOP = document.getElementById('modalTitleTipoP');
// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM_TIPOP = document.getElementById('saveFormTipoP'),
    ID_TIPO_PRODUCTO = document.getElementById('idTipoProducto'),
    NOMBRE_TIPO_PRODUCTO = document.getElementById('nombreTipoProducto')

/*
*Elementos para la tabla VALORACIONES_PRODUCTOS
*/
// Constante para establecer el formulario de buscar.
// Constantes para establecer los elementos de la tabla.
const TABLE_BODY_COMENTARIO = document.getElementById('tableBodyTipoP'),
    ROWS_FOUND_COMENTARIO = document.getElementById('rowsFoundTipoP');
// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL_COMENTARIO = new bootstrap.Modal('#saveModalTipoP'),
    MODAL_TITLE_COMENTARIO = document.getElementById('modalTitleTipoP');
// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM_COMENTARIO = document.getElementById('saveFormTipoP'),
    ID_VALORACION_PRODUCTO = document.getElementById('idTipoProducto'),
    ID_OPINION = document.getElementById('nombreTipoProducto');
    ID_PRODUCTO_VALORADO = document.getElementById('');
    ID_CLIENTE = document.getElementById('');
    ESTADO_VALORACION = document.getElementById('');


// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Gestionar productos';
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

// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (ID_PRODUCTO.value) ? action = 'updateRow' : action = 'createRow';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(PRODUCTO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        SAVE_MODAL.hide();
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
const fillTable = async (form = null) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND.textContent = '';
    TABLE_BODY.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'searchRows' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(PRODUCTO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY.innerHTML += `
                <tr>
                    <td><img src="${SERVER_URL}images/productos/${row.imagen}" height="50"></td>
                    <td>${row.nombre_producto}</td>
                    <td>${row.nombre_categoria}</td>
                    <td>${row.tipo_producto}</td>
                    <td>${row.nombre_deporte}</td>
                    <td>
                        <button type="button" class="btn btn-success" onclick="openDetails(${row.id_producto})">
                        <i class="fa-regular fa-square-plus"></i>
                        </button>
                        <button type="button" class="btn btn-info" onclick="openUpdate(${row.id_producto})">
                        <i class="fa-solid fa-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger" onclick="openDelete(${row.id_producto})">
                        <i class="fa-regular fa-trash-can"></i>
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
    MODAL_TITLE.textContent = 'Crear producto';
    // Se prepara el formulario.
    SAVE_FORM.reset();
    fillSelect(CATEGORIA_API, 'readAll', 'categoriaProducto');
    fillSelect(TIPO_PRODUCTO_API, 'readAll_TipoP', 'tipoProducto');
    fillSelect(DEPORTE_API, 'readAll', 'deporteProducto');
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openUpdate = async (id) => {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idProducto', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(PRODUCTO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'Actualizar producto';
        // Se prepara el formulario.
        SAVE_FORM.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_PRODUCTO.value = ROW.id_producto;
        NOMBRE_PRODUCTO.value = ROW.nombre_producto;
        DESCRIPCION_PRODUCTO.value = ROW.descripcion;
        fillSelect(CATEGORIA_API, 'readAll', 'categoriaProducto', ROW.id_categoria);
        fillSelect(TIPO_PRODUCTO_API, 'readAll_TipoP', 'tipoProducto', ROW.id_tipo_producto);
        fillSelect(DEPORTE_API, 'readAll', 'deporteProducto', ROW.id_deporte);
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
    const RESPONSE = await confirmAction('¿Desea eliminar el producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idProducto', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(PRODUCTO_API, 'deleteRow', FORM);
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
*   Funciones para la tabla DETALLE_PRODUCTO
*/

// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM_DETALLE.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (ID_DETALLE.value) ? action = 'updateRow_detalleProducto' : action = 'createRow_detalleProducto';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM_DETALLE);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(PRODUCTO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        //SAVE_MODAL_DETALLE.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTableDetails();
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
const fillTableDetails = async (form = null) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND_DETALLE.textContent = '';
    TABLE_BODY_DETALLE.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'searchRows' : action = 'readAll_detalle';
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(PRODUCTO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY_DETALLE.innerHTML += `
                <tr>
                    <td>${row.precio}</td>
                    <td>${row.cantidad_disponible}</td>
                    <td>${row.talla}</td>
                    <td>${row.genero}</td>
                    <td>${row.nombre_producto}</td>
                    <td>
                        <button type="button" class="btn btn-info" onclick="openUpdateDetails(${row.id_detalle_producto})">
                        <i class="fa-solid fa-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger" onclick="openDeleteDetails(${row.id_detalle_producto})">
                        <i class="fa-regular fa-trash-can"></i>
                        </button>
                        <button type="button" class="btn btn-warning" onclick="openDeleteDetails(${row.id_detalle_producto})">
                        <i class="fa-regular fa-comment-dots"></i>
                        </button>
                    </td>
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
const openDetails = (id_producto) => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL_DETALLE.show();
    MODAL_TITLE_DETALLE.textContent = 'Crear Detalle producto';
    // Se prepara el formulario.
    SAVE_FORM_DETALLE.reset();

    ID_PRODUCTO_DETALLE.value = id_producto;
    fillSelect(TALLA_API, 'readAll', 'tallaDetalle');
    fillSelect(GENERO_API, 'readAll', 'generoDetalle');

    fillTableDetails();
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
    const DATA = await fetchData(PRODUCTO_API, 'readOne_detalleProducto', FORM_DETALLE);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL_DETALLE.show();
        MODAL_TITLE_DETALLE.textContent = 'Actualizar detalle producto';
        // Se prepara el formulario.
        SAVE_FORM_DETALLE.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_DETALLE.value = ROW.id_detalle_producto;
        PRECIO_DETALLE.value = ROW.precio;
        EXISTENCIAS_DETALLE.value = ROW.cantidad_disponible;
        fillSelect(TALLA_API, 'readAll', 'tallaDetalle', ROW.id_talla);
        fillSelect(GENERO_API, 'readAll', 'generoDetalle', ROW.id_genero);
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
        const DATA = await fetchData(PRODUCTO_API, 'deleteRow_detalleProducto', FORM);
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
*   Funciones para la tabla TIPO_PRODUCTO
*/

// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM_TIPOP.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (ID_TIPO_PRODUCTO.value) ? action = 'updateRow' : action = 'createRow';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM_TIPOP);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(TIPOP_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        //SAVE_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTableTipoP();
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
const fillTableTipoP = async (form = null) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND_TIPOP.textContent = '';
    TABLE_BODY_TIPOP.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'searchRows' : action = 'readAll_TipoP';
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(TIPOP_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros fila por fila.
        DATA.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY_TIPOP.innerHTML += `
                <tr>
                    
                    <td>${row.tipo_producto}</td>
                    <td>
                        <button type="button" class="btn btn-info" onclick="openUpdateTipoP(${row.id_tipo_producto})">
                        <i class="fa-solid fa-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger" onclick="openDeleteTipoP(${row.id_tipo_producto})">
                        <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
        ROWS_FOUND_TIPOP.textContent = DATA.message;
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openCreateTipoP = () => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL_TIPOP.show();
    MODAL_TITLE_TIPOP.textContent = 'Crear tipo de producto';
    // Se prepara el formulario.
    SAVE_FORM_TIPOP.reset();

    fillTableTipoP();
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openUpdateTipoP = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM_TIPOP = new FormData();
    FORM_TIPOP.append('idTipoProducto', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(TIPOP_API, 'readOne', FORM_TIPOP);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL_TIPOP.show();
        MODAL_TITLE_TIPOP.textContent = 'Actualizar tipo de producto';
        // Se prepara el formulario.
        SAVE_FORM_TIPOP.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_TIPO_PRODUCTO.value = ROW.id_tipo_producto;
        NOMBRE_TIPO_PRODUCTO.value = ROW.tipo_producto;

    } else {
        sweetAlert(2, DATA.error, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openDeleteTipoP = async (id) => {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar la categoría de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM_TIPOP = new FormData();
        FORM_TIPOP.append('idTipoProducto', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(TIPOP_API, 'deleteRow', FORM_TIPOP);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se muestra un mensaje de éxito.
            await sweetAlert(1, DATA.message, true);
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTableTipoP();
        } else {
            sweetAlert(2, DATA.error, false);
        }
    }
}


/*
*   Funciones para la tabla tb_VALORACIONES_PRODUCTOS
*/

// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM_TIPOP.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (ID_TIPO_PRODUCTO.value) ? action = 'updateRow' : action = 'createRow';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM_TIPOP);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(TIPOP_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        //SAVE_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTableTipoP();
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
const fillTableComentario = async (form = null) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND_TIPOP.textContent = '';
    TABLE_BODY_TIPOP.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'searchRows' : action = 'readAll_TipoP';
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(TIPOP_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros fila por fila.
        DATA.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY_TIPOP.innerHTML += `
                <tr>
                    
                    <td>${row.tipo_producto}</td>
                    <td>
                        <button type="button" class="btn btn-info" onclick="openUpdateTipoP(${row.id_tipo_producto})">
                        <i class="fa-solid fa-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger" onclick="openDeleteTipoP(${row.id_tipo_producto})">
                        <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
        ROWS_FOUND_TIPOP.textContent = DATA.message;
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openCreateComentario = () => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL_TIPOP.show();
    MODAL_TITLE_TIPOP.textContent = 'Crear tipo de producto';
    // Se prepara el formulario.
    SAVE_FORM_TIPOP.reset();

    fillTableTipoP();
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openUpdateComentario = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM_TIPOP = new FormData();
    FORM_TIPOP.append('idTipoProducto', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(TIPOP_API, 'readOne', FORM_TIPOP);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL_TIPOP.show();
        MODAL_TITLE_TIPOP.textContent = 'Actualizar tipo de producto';
        // Se prepara el formulario.
        SAVE_FORM_TIPOP.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_TIPO_PRODUCTO.value = ROW.id_tipo_producto;
        NOMBRE_TIPO_PRODUCTO.value = ROW.tipo_producto;

    } else {
        sweetAlert(2, DATA.error, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openDeleteComentario = async (id) => {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar la categoría de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM_TIPOP = new FormData();
        FORM_TIPOP.append('idTipoProducto', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(TIPOP_API, 'deleteRow', FORM_TIPOP);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se muestra un mensaje de éxito.
            await sweetAlert(1, DATA.message, true);
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTableTipoP();
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
    const PATH = new URL(`${SERVER_URL}reports/admin/productos.php`);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}