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
    event.preventDefault();
    const FORM = new FormData(PASSWORD_FORM);
    const DATA = await fetchData(USER_API, 'changePassword', FORM);
    if (DATA.status) {
        PASSWORD_MODAL.hide();
        sweetAlert(1, DATA.message, true);
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

const openPassword = () => {
    PASSWORD_MODAL.show();
    PASSWORD_FORM.reset();
}
