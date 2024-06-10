/*
*   Controlador es de uso general en las páginas web del sitio público.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'services/public/cliente.php';
// Constante para establecer el elemento del contenido principal.
const MAIN = document.querySelector('main');
MAIN.style.paddingTop = '75px';
MAIN.style.paddingBottom = '100px';
MAIN.classList.add('container');
// Se establece el título de la página web.
document.querySelector('title').textContent = 'SportFusion - Store';
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
    // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
    if (DATA.session) {
        // Se verifica si la página web no es el inicio de sesión, de lo contrario se direcciona a la página web principal.
        if (!location.pathname.endsWith('login.html')) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin', `
                <header>
                    <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
                        <div class="container">
                            <a class="navbar-brand" href="index.html"><img src="../../resources/img/logoSF.png" height="50" alt="SportFusion"></a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                                <div class="navbar-nav ms-auto">
                                    <a class="nav-link" href="deportes.html"><i class="fa-solid fa-basketball"></i> Deportes</a>
                                    <a class="nav-link" href="index.html"><i class="fa-solid fa-store"></i> Productos</a>
                                    <a class="nav-link" href="carrito.html"><i class="fa-solid fa-cart-shopping"></i> Carrito de compras</a>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user"></i>Cuenta: <b>${DATA.username}</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="perfilUsuario.html">Editar perfil</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="historialCompras.html">Historial de compras</a></li>
                                        </ul>
                                    </li>

                                    <a class="nav-link" href="#" onclick="logOut()"> Cerrar sesión <i class="fa-solid fa-arrow-right-to-bracket"></i></a>

                                    

                                </div>
                            </div>
                        </div>
                    </nav>
                </header>
            `);
        } else {
            location.href = 'index.html';
        }
    } else {
        // Se agrega el encabezado de la página web antes del contenido principal.
        MAIN.insertAdjacentHTML('beforebegin', `
            <header>
                <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
                    <div class="container"> 
                        <a class="navbar-brand" href="index.html"><img src="../../resources/img/logoSF.png" height="50" alt="SportFusion"></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav ms-auto">
                                <a class="nav-link" href="deportes.html"><i class="fa-solid fa-basketball"></i> Deportes</a>
                                <a class="nav-link" href="index.html"><i class="fa-solid fa-store"></i> Productos</a>
                                <a class="nav-link" href="signup.html"><i class="fa-solid fa-user"></i> Crear cuenta</a>
                                <a class="nav-link" href="login.html"><i class="fa-solid fa-arrow-right-to-bracket"></i> Iniciar sesión</a>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
        `);
    }
    // Se agrega el pie de la página web después del contenido principal.
    MAIN.insertAdjacentHTML('afterend', `
        <footer>
            <nav class="navbar fixed-bottom bg-body-tertiary">
                <div class="container">
                    <div>
                        <h6>SportsFusion</h6>
                        <p> Todos los derechos reservados - 2024  </p>
                    </div>
                    <div>
                        <h6>Integrantes</h6>
                        <p> | Jafet Melara - 20220188 | Kevin Rodríguez - 20220286 | Dominic Mejía - 20220211 | </p>
                    </div>
                </div>
            </nav>
        </footer>
        
    `);
}