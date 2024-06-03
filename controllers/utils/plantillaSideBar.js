const ADMIN_API = 'services/admin/administrador.php';

const plantillaSideBar =  `
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
                    <i class="fa-solid fa-user-tie"></i>
                        <span>Administradores</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="clientes.html" class="sidebar-link">
                    <i class="fa-solid fa-users"></i>
                        <span>Clientes</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="productos.html" class="sidebar-link">
                    <i class="fa-solid fa-book"></i>
                        <span>Productos</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="pedidos.html" class="sidebar-link">
                    <i class="fa-solid fa-truck"></i>
                        <span>Pedidos</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="estado_pedido.html" class="sidebar-link">
                    <i class="fa-solid fa-dolly"></i>
                        <span>Estado de pedidos</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="deportes.html" class="sidebar-link">
                    <i class="fa-solid fa-basketball"></i>
                        <span>Deportes</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="categorias.html" class="sidebar-link">
                    <i class="fa-solid fa-list"></i>
                        <span>Categorias</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="tallas.html" class="sidebar-link">
                    <i class="fa-solid fa-shirt"></i>
                        <span>Tallas</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="generos.html" class="sidebar-link">
                    <i class="fa-solid fa-mars-and-venus"></i>
                        <span>Generos</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="index.html" class="sidebar-link" onclick="logOut()">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
`

document.getElementById('sidebar').innerHTML = plantillaSideBar;

