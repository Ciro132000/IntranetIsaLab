<div class="sidebar-container bg-sidebar border ">
    <div class="logo">
        <img src="<?php echo SERVERURL; ?>vistas/img/logo.png" style="width: 100%;">
    </div>
    <hr>
    <div class="menu">
        <a href="<?php echo SERVERURL; ?>home/" class="d-block text-dark p-3"><i class="fas fa-clinic-medical mr-2"></i></i>Inicio</a>
        <a href="<?php echo SERVERURL; ?>administradores/" class="d-block text-dark p-3"><i class="fas fa-people-arrows mr-2 "></i>Administradores</a>
        <a href="<?php echo SERVERURL; ?>clientes/" class="d-block text-dark p-3"><i class="fas fa-user-friends mr-2 "></i>Clientes</a>
        <a href="<?php echo SERVERURL; ?>productos/" class="d-block text-dark p-3"><i class="fas fa-capsules mr-2"></i></i>Productos</a>
        <a href="<?php echo SERVERURL; ?>ventas/" class="d-block text-dark p-3"><i class="fas fa-table mr-2 "></i>Registros de ventas</a>
        <a href="<?php echo SERVERURL . "administradores-modificar/" . $lc->encryption($_SESSION['id_spm']) . "/"; ?>" class="d-block text-dark p-3"><i class="fas fa-cogs mr-2 "></i>Configuración</a>
    </div>
</div>
