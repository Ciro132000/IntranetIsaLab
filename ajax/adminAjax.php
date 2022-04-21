<?php
    $peticionAjax=true;
    require_once "../config/APP.php";

    if(isset($_POST['nombre']) || isset($_POST['ideliminar']) || isset($_POST['idactualizardatos']) || isset($_POST['id_actualizar_acceso']) ){
        /* Instancia al controlador */
        require_once "../controladores/administradorControlador.php";
        $ins_admin=new administradorControlador();

         /* Agregar un usuario */
        if(isset($_POST['nombre'])){
            echo $ins_admin->agregar_admin_controlador();
        }

        /* Eliminar cliente */
        if(isset($_POST['ideliminar'])){
            echo $ins_admin->eliminar_admin_controlador();
        }

        /* actualizar datos personales del cliente */
        if(isset($_POST['idactualizardatos'])){
            echo $ins_admin->actualizar_datos_admin_controlador();
        }

        /* actualizar datos usuario o constraseña del cliente */
        if(isset($_POST['id_actualizar_acceso'])){
            echo $ins_admin->actualizar_acceso_admin_controlador();
        }

    } else{
        session_start(['name'=>'SPM']);
        session_unset();
        session_destroy();
        header("location: ".SERVERURL."login/");
        exit();
    }