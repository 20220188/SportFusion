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
                <a href="tipo_productos.html" class="sidebar-link">
                <i class="lni lni-layout"></i>
                    <span>tipo de productos</span>
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
                    <a href="categorias.html" class="sidebar-link">
                        <i class="lni lni-list"></i>
                        <span>Categorias</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="tallas.html" class="sidebar-link">
                    <i class="lni lni-sort-amount-asc"></i>
                        <span>Tallas</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="index.html" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
`

document.getElementById('sidebar').innerHTML = plantillaSideBar;

