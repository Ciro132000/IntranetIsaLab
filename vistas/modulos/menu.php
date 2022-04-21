<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container-fluid">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo SERVERURL; ?>vistas/img/avatar-predeterminado.jpg" class="img-fluid rounded-circle avatar mr-2 " alt="">
                        <?php echo $_SESSION['nombre_spm'] . " " . $_SESSION['apellido_spm']; ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Mi perfil</a></li>
                        <li><a class="dropdown-item" href="<?php echo SERVERURL."administradores-modificar/".$lc->encryption($_SESSION['id_spm'])."/"; ?>">Configuración</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item btn-exit-system" href="#">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>

        </div>
    </div>

</nav>