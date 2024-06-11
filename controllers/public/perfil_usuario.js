// Constantes para establecer los elementos del formulario de editar perfil.
const PROFILE_FORM = document.getElementById('profileForm'),
    NOMBRE_CLIENTE = document.getElementById('nombreclientePerfil'),
    TELEFONO_CLIENTE = document.getElementById('telefonoclientePerfil'),
    CORREO_CLIENTE = document.getElementById('correoclientePerfil'),
    DIRECCION_CLIENTE = document.getElementById('direccionclientePerfil');
const PASSWORD_MODAL = new bootstrap.Modal(document.getElementById('passwordModal'));
const PASSWORD_FORM = document.getElementById('passwordForm');

document.addEventListener('DOMContentLoaded', async () => {
    loadTemplate();
    document.getElementById('mainTitle').textContent = 'Editar perfil';
    const DATA = await fetchData(USER_API, 'readProfile');
    if (DATA.status) {
        const ROW = DATA.dataset;
        NOMBRE_CLIENTE.value = ROW.nombre_cliente;
        TELEFONO_CLIENTE.value = ROW.telefono_cliente;
        CORREO_CLIENTE.value = ROW.correo_cliente;
        DIRECCION_CLIENTE.value = ROW.dirección_cliente;
    } else {
        sweetAlert(2, DATA.error, null);
    }
});

PROFILE_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    const fetchId = async () => {
        const FORM = new FormData(PROFILE_FORM);
        const PROFILE = await fetchData(USER_API, 'readProfile');
        console.log(PROFILE.dataset.id_cliente)
        return FORM;
    }

    const fetchProfile = async (FORM) => {
        const DATA = await fetchData(USER_API, 'editProfile', FORM);

        if (DATA.status) {
            sweetAlert(1, DATA.message, true);
        } else {
            sweetAlert(2, DATA.error, false);
        }
    }

    fetchProfile(await fetchId());
});

PASSWORD_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(PASSWORD_FORM);
    console.log([...FORM.entries()]);
    // Petición para actualizar la constraseña.
    const DATA = await fetchData(USER_API, 'changePassword', FORM);
    console.log(DATA); // Loguea la respuesta de la API
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        PASSWORD_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

/*
*   Función para preparar el formulario al momento de cambiar la constraseña.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openPassword = () => {
    // Se abre la caja de diálogo que contiene el formulario.
    PASSWORD_MODAL.show();
    // Se restauran los elementos del formulario.
    PASSWORD_FORM.reset();
}
