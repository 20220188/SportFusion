const fillTable = async (form = null) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND.textContent = '';
    TABLE_BODY.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'searchForm' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(ADMINISTRADOR_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros fila por fila.
        DATA.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY.innerHTML += `
            <tr>
                <td>${row.id_nivel_usuario}</td>
                <td>${row.nivel_usuario}</td>
                <td>
                    <button class="edit-button" onclick="openUpdate(${row.id_nivel_usuario})">
                    <img src="../../api/images/Edit.png">
                    </button>
                    <button class="edit-button"(${row.id_nivel_usuario})>
                    <img src="../../api/images/Remove.png">
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