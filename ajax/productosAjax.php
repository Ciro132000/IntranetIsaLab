<?php
    $peticionAjax=true;
    require_once "../config/APP.php";

    if(isset($_POST['nombre_nuevo']) || isset($_POST['id_product_eliminar']) || isset($_POST['idproductoactu'])|| isset($_POST['id_foto_actu'])
    || isset($_POST['nombre_categoria']) || isset($_POST['cod_oferta']) || isset($_POST['id_cat_eliminar']) || isset($_POST['id_dsc_eliminar'])){
        /* Instancia al controlador */
        require_once "../controladores/productoControlador.php";
        $ins_producto=new productoControlador();

         /* Agregar un producto */
        if(isset($_POST['nombre_nuevo'])){
            echo $ins_producto->agregar_producto_controlador();
        }

        /*Eliminar un producto */
        if(isset($_POST['id_product_eliminar'])){
            echo $ins_producto->eliminar_producto_controlador();
        }

        /* Actualizar producto */
        if(isset($_POST['idproductoactu'])){
            echo $ins_producto->actualizar_productos_controlador();
        }

        /* Actualizar producto */
        if(isset($_POST['id_foto_actu'])){
            echo $ins_producto->actualizar_foto_productos_controlador();
        }

        /* agregar categoria producto */
        if(isset($_POST['nombre_categoria'])){
            echo $ins_producto->agregar_categoria_producto_controlador();
        }

        /* eliminar categoria producto */
        if(isset($_POST['id_cat_eliminar'])){
            echo $ins_producto->elminar_categoria_producto_controlador();
        }

        /* agregar oferta producto */
        if(isset($_POST['cod_oferta'])){
            echo $ins_producto->agregar_oferta_producto_controlador();
        }

        /* eliminar oferta producto */
        if(isset($_POST['id_dsc_eliminar'])){
            echo $ins_producto->eliminar_oferta_producto_controlador();
        }

    } else{
        session_start(['name'=>'SPM']);
        session_unset();
        session_destroy();
        header("location: ".SERVERURL."login/");
        exit();
    }