<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "modulos/head.php" ?>
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL; ?>vistas/css/style.css">
    <title><?php echo COMPANY ?></title>
</head>

<body>

    <?php
    $peticionAjax = false;

    require_once "./controladores/clienteControlador.php";
    require_once "./controladores/administradorControlador.php";

    $admin=new administradorControlador();
    $lista_admin=$admin->listar_admin_controlador();

    $clientes=new clienteControlador();
    $lista_clientes=$clientes->listar_cliente_controlador();
    
    require_once "./controladores/vistasControlador.php";
    $IV = new vistasControlador();
    $vistas = $IV->obtener_vistas_controlador();
    if ($vistas == "login" || $vistas == "404") {
        require_once "./vistas/contenidos/" . $vistas . "-view.php";
    } else {
        session_start(['name' => 'SPM']);

        $paginas=explode("/", $_GET['ruta']);

        require_once "./controladores/loginControlador.php";
        $lc = new loginControlador();

        /*verificando si el usuario inicio sesion */
        if (!isset($_SESSION['token_spm'])) {
            echo $lc->forzar_cierre_sesion_controlador();
            exit();
        }
    ?>


        <div class="d-flex">

            <?php include "modulos/sidebar.php"; ?>

            <div class="w-100">

                <?php
                include "modulos/menu.php";
                include $vistas;
                ?>

            </div>
        </div>

    <?php

        include "./vistas/modulos/logOut.php";

    }
    include "modulos/partebaja.php" ?>


</body>

</html>