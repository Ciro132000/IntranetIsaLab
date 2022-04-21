<?php
if ($peticionAjax) {
    require_once "../modelos/productoModelo.php";
} else {
    require_once "./modelos/productoModelo.php";
}

class productoControlador extends productoModelo
{

    /*Controlador para agregar nuevo producto */
    public function agregar_producto_controlador()
    {
        $nombre = mainModel::limpiar_cadena($_POST['nombre_nuevo']);
        $precio = mainModel::limpiar_cadena($_POST['precio_nuevo']);
        $categoria = mainModel::limpiar_cadena($_POST['categoria_nuevo']);
        $oferta = mainModel::limpiar_cadena($_POST['oferta']);
        $detalle = mainModel::limpiar_cadena($_POST['detalle_nuevo']);
        $stock = mainModel::limpiar_cadena($_POST['stock_nuevo']);

        /*Comprobando campos vacios */
        if ($nombre == "" || $precio == "" || $categoria == "" || $detalle == "" || $stock == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Ingrese todos los datos obligatorios",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }


        if (mainModel::verificar_datos("[0-9,.]{0,12}", $precio)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Ingresar un precio válido",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (mainModel::verificar_datos("[0-9]{0,12}", $stock)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Ingresar un stock válido",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }


        /* Recibiendo la imagen */
        $foto = $_FILES['foto_nuevo']['name'];
        $fototemporal = $_FILES['foto_nuevo']['tmp_name'];

        /*Comprobando envio de imagen */
        if ($foto == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "Seleccione una imagen para el producto",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        /*Subiendo imagen al sistema */
        $type = 'jpg';
        $nombre_foto = $nombre . "_" . $categoria . "." . $type;

        $fotourl = "../vistas/img/img_productos/" . $nombre_foto;
        copy($fototemporal, $fotourl);

        /* Registrando producto */
        $datos_producto_reg = [
            "nombre" => $nombre,
            "oferta" => $oferta,
            "categoria" => $categoria,
            "detalle" => $detalle,
            "precio" => $precio,
            "stock" => $stock,
            "img" => $nombre_foto
        ];

        $agregar_producto = productoModelo::agregar_producto_modelo($datos_producto_reg);

        if ($agregar_producto->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Producto registrado",
                "Texto" => "Los datos del producto se han sido registrados con exito",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos podido registrar el usuario",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }/*fin controlador*/

    /*Controlador para listar productoss */
    public function listar_producto_controlador()
    {
        $lista_productos = productoModelo::listar_producto_modelo();
        return $lista_productos->fetchAll();
    }/*fin controlador*/

    /* Control para listar las categorias de los productos */
    public function listar_categoria_productos_controlador()
    {
        return productoModelo::listar_categorias_productos_modelo();
    }

    /* Control para listar las ofertas de los productos */
    public function listar_oferta_productos_controlador()
    {
        return productoModelo::listar_oferta_productos_modelo();
    }

    /*Control para eliminar producto */
    public function eliminar_producto_controlador()
    {
        $id = $_POST['id_product_eliminar'];
        $id = mainModel::limpiar_cadena($id);

        /*Comprobando producto en DB*/
        $check_product = mainModel::ejecutar_consulta_simple("SELECT idproducto FROM producto WHERE idproducto='$id'");
        if ($check_product->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "El producto que intenta eliminar no existe",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_producto = productoModelo::eliminar_producto_modelo($id);

        if ($eliminar_producto->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Producto eliminado",
                "Texto" => "",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "No se pudo eliminar el producto, por favor intente más tarde",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
        exit();
    }/*fin controlador*/

    /*Control para editar cliente */
    public function datos_productos_controlador($tipo, $id)
    {
        $tipo = mainModel::limpiar_cadena($tipo);

        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);

        return productoModelo::datos_producto_modelo($tipo, $id);
    }/*fin controlador*/

    /*Control para actualizar producto */
    public function actualizar_productos_controlador()
    {
        $id = mainModel::decryption($_POST['idproductoactu']);
        $id = mainModel::limpiar_cadena($id);

        /*== Comprobando producto en la BD ==*/
        $check_pro = mainModel::ejecutar_consulta_simple("SELECT * FROM producto WHERE idproducto='$id'");
        if ($check_pro->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El producto que intenta modificar no existe",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $nombre = mainModel::limpiar_cadena($_POST['nombre_actu_prod']);
        $precio = mainModel::limpiar_cadena($_POST['precio_actu']);
        $categoria = mainModel::limpiar_cadena($_POST['categoria_actu']);
        $oferta = mainModel::limpiar_cadena($_POST['oferta_actu']);
        $detalle = mainModel::limpiar_cadena($_POST['detalle_actu']);
        $stock = mainModel::limpiar_cadena($_POST['stock_actu']);

        /*Comprobando campos vacios */
        if ($nombre == "" || $precio == "" || $categoria == "" || $detalle == "" || $stock == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Ingrese todos los datos obligatorios",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }


        if (mainModel::verificar_datos("[0-9,.]{0,12}", $precio)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Ingresar un precio válido",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (mainModel::verificar_datos("[0-9]{0,12}", $stock)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Ingresar un stock válido",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }


        /* actualizando datos */
        $datos_producto_actu = [
            "nombre" => $nombre,
            "oferta" => $oferta,
            "categoria" => $categoria,
            "detalle" => $detalle,
            "precio" => $precio,
            "stock" => $stock,
            "id" => $id
        ];

        if (productoModelo::actualizar_datos_producto_modelo($datos_producto_actu)) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Producto actualizado",
                "Texto" => "Los datos del producto han sido actualizados con exito",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos podido actualizar los datos del producto",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }/*fin controlador*/

    public function actualizar_foto_productos_controlador(){

        $id = mainModel::decryption($_POST['id_foto_actu']);
        $id = mainModel::limpiar_cadena($id);

        $nombre = mainModel::limpiar_cadena($_POST['foto_nombre']);       

         /* Recibiendo la imagen */
         $foto = $_FILES['foto_actu']['name'];
         $fototemporal = $_FILES['foto_actu']['tmp_name'];
 
         /*Comprobando envio de imagen */
         if ($foto == "") {
             $alerta = [
                 "Alerta" => "simple",
                 "Titulo" => "Ocurrió un error inesperado",
                 "Texto" => "Seleccione una imagen para el producto",
                 "Tipo" => "error"
             ];
             echo json_encode($alerta);
             exit();
         }
 
         /*Subiendo imagen al sistema */
         $type = 'jpg';
         $nombre_foto = $nombre . "_" . $id. "." . $type;
 
         $fotourl = "../vistas/img/img_productos/" . $nombre_foto;
         copy($fototemporal, $fotourl);
 
         /* Registrando producto */
         $foto_producto_actu = [
             "img" => $nombre_foto,
             "id"=>$id
         ];
 
         $agregar_producto = productoModelo::actualizar_foto_producto_modelo($foto_producto_actu);
 
         if ($agregar_producto->rowCount() <=1) {
             $alerta = [
                 "Alerta" => "recargar",
                 "Titulo" => "Producto actualizado",
                 "Texto" => "La imagen del producto se ha actualizado con exito",
                 "Tipo" => "success"
             ];
         } else {
             $alerta = [
                 "Alerta" => "simple",
                 "Titulo" => "Ocurrió un error inesperado",
                 "Texto" => "No hemos podido actualizar",
                 "Tipo" => "error"
             ];
         }
         echo json_encode($alerta);
    }

    /*Control para agregar categoria */
    public function agregar_categoria_producto_controlador(){
        $nombre = mainModel::limpiar_cadena($_POST['nombre_categoria']);

        /*Comprobando campos vacios */
        if ($nombre == "" ) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Debe agregar un nombre",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $agregar_producto = productoModelo::agregar_categoria_producto_modelo($nombre);

        if ($agregar_producto->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Producto registrado",
                "Texto" => "Los datos del producto se han sido registrados con exito",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos podido registrar el usuario",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }/*fin controlador*/

    /*Control para eliminar categoria */
    public function elminar_categoria_producto_controlador(){
        $id = $_POST['id_cat_eliminar'];
        $id = mainModel::limpiar_cadena($id);

        /*Comprobando producto en DB*/
        $check_cat = mainModel::ejecutar_consulta_simple("SELECT id_categoria FROM categoria WHERE id_categoria='$id'");
        if ($check_cat->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "La categoria que intenta eliminar no existe",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_categoria = productoModelo::eliminar_categoria_producto_modelo($id);

        if ($eliminar_categoria->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Categoria eliminada",
                "Texto" => "",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "No se pudo eliminar la categoria, por favor intente más tarde",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
        exit();
    }/*fin controlador*/

    /*Control para agregar oferta */
    public function agregar_oferta_producto_controlador(){
        $codigo = mainModel::limpiar_cadena($_POST['cod_oferta']);
        $descuento = mainModel::limpiar_cadena($_POST['dsc_oferta']);

        /*Comprobando campos vacios */
        if ($codigo == "" || $descuento == "" ) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Debe agregar rellenar los campos",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $oferta=[
            "codigo"=> $codigo,
            "descuento"=>$descuento
        ];

        $agregar_producto = productoModelo::agregar_oferta_producto_modelo($oferta);

        if ($agregar_producto->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Producto registrado",
                "Texto" => "Los datos del producto se han sido registrados con exito",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos podido registrar el usuario",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }/*fin controlador*/

    /*Control para eliminar oferta */
    public function eliminar_oferta_producto_controlador(){
        $id = $_POST['id_dsc_eliminar'];
        $id = mainModel::limpiar_cadena($id);

        /*Comprobando producto en DB*/
        $check_ofer = mainModel::ejecutar_consulta_simple("SELECT id_oferta FROM oferta WHERE id_oferta='$id'");
        if ($check_ofer->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "La oferta que intenta eliminar no existe",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_oferta = productoModelo::eliminar_oferta_producto_modelo($id);

        if ($eliminar_oferta->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "OFERTA eliminada",
                "Texto" => "",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "No se pudo eliminar la OFERTA, por favor intente más tarde",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
        exit();
    }/*fin controlador*/

}
