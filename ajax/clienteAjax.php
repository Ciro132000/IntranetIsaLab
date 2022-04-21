<?php
    $peticionAjax=true;
    require_once "../config/APP.php";

    if(isset($_POST['dni']) || isset($_POST['ideliminar']) || isset($_POST['idactualizardatos']) || isset($_POST['id_actualizar_acceso']) ){
        /* Instancia al controlador */
        require_once "../controladores/clienteControlador.php";
        $ins_cliente=new clienteControlador();

         /* Agregar un usuario */
        if(isset($_POST['dni']) && isset($_POST['nombre'])){
            echo $ins_cliente->agregar_cliente_controlador();
        }

        /* Eliminar cliente */
        if(isset($_POST['ideliminar'])){
            echo $ins_cliente->eliminar_cliente_controlador();
        }

        /* actualizar datos personales del cliente */
        if(isset($_POST['idactualizardatos'])){
            echo $ins_cliente->actualizar_datos_cliente_controlador();
        }

        /* actualizar datos usuario o constraseña del cliente */
        if(isset($_POST['id_actualizar_acceso'])){
            echo $ins_cliente->actualizar_acceso_cliente_controlador();
        }

    } else{
        session_start(['name'=>'SPM']);
        session_unset();
        session_destroy();
        header("location: ".SERVERURL."login/");
        exit();
    }