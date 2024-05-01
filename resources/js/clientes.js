const USER_API = 'services/admin/administrador.php';
// Constante para establecer el elemento del contenido principal.
const MAIN = document.querySelector('main');
MAIN.style.paddingTop = '75px';
MAIN.style.paddingBottom = '100px';
MAIN.classList.add('container');
// Se establece el título de la página web.
document.querySelector('title').textContent = 'SportFusion - Dashboard';
// Constante para establecer el elemento del título principal.
const MAIN_TITLE = document.getElementById('mainTitle');
MAIN_TITLE.classList.add('text-center', 'py-3');

/*  Función asíncrona para cargar el encabezado y pie del documento.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const loadTemplate = async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const DATA = await fetchData(USER_API, 'getUser');
    // Se verifica si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
    if (DATA.session) {
        // Se comprueba si existe un alias definido para el usuario, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin', `
            <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>

                </button>
                <div class="sidebar-logo">
                    <a href="dashboard.html">SportFusion</a>
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="administrador.html" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Administradores</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="clientes.html" class="sidebar-link">
                        <i class="lni lni-users"></i>
                        <span>Clientes</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="productos.html" class="sidebar-link">
                        <i class="lni lni-agenda"></i>
                        <span>Productos</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="pedidos.html" class="sidebar-link">
                        <i class="lni lni-delivery"></i>
                        <span>Pedidos</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="deportes.html" class="sidebar-link">
                        <i class="lni lni-basketball"></i>
                        <span>Deportes</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="nivel_usuarios.html" class="sidebar-link">
                        <i class="lni lni-network"></i>
                        <span>Niveles de usuario</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="categorias.html" class="sidebar-link">
                        <i class="lni lni-list"></i>
                        <span>Categorias</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="index.html" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>`);
    } else {
        sweetAlert(3, DATA.error, false, 'index.html');
    } } else {
        // Se comprueba si la página web es la principal, de lo contrario se direcciona a iniciar sesión.
        if (location.pathname.endsWith('clientes.html')) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin', `
                <header>
                    <nav class="navbar fixed-top bg-body-tertiary">
                        <div class="container">
                            <a class="navbar-brand" href="clientes.html">
                                <img src="../../api/images/logoSF.png" alt="inventory" width="50">
                            </a>
                        </div>
                    </nav>
                </header>
            `);
        } 
    }
}