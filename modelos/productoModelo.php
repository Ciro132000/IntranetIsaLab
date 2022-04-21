<?php
require_once "mainModel.php";

class productoModelo extends mainModel
{

    /* Modelo para agregar cliente */
    protected static function agregar_producto_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO producto(nom_product,id_oferta,id_categoria,detalle,precio,stock,img)
        VALUES(:nom_product,:id_oferta,:id_categoria,:detalle,:precio,:stock,:img)");

        $sql->bindParam(":nom_product", $datos['nombre']);
        $sql->bindParam(":id_oferta", $datos['oferta']);
        $sql->bindParam(":id_categoria", $datos['categoria']);
        $sql->bindParam(":detalle", $datos['detalle']);
        $sql->bindParam(":precio", $datos['precio']);
        $sql->bindParam(":stock", $datos['stock']);
        $sql->bindParam(":img", $datos['img']);
        $sql->execute();

        return $sql;
    }


    /*Modelo para listar productos */
    protected static function listar_producto_modelo()
    {
        $sql = mainModel::conectar()->prepare("SELECT producto.idproducto ,producto.img,producto.nom_product,categoria.nombre,oferta.descuento, producto.detalle,producto.precio,producto.stock FROM producto 
        INNER JOIN categoria ON producto.id_categoria=categoria.id_categoria
        INNER JOIN oferta ON producto.id_oferta=oferta.id_oferta");
        $sql->execute();

        return $sql;
    }
    /*fin Modelo*/

    /*Modelo para listar las categorias de productos */
    protected static function listar_categorias_productos_modelo()
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM categoria");
        $sql->execute();

        return $sql;
    }

    /*Modelo para listar las descuentos de productos */
    protected static function listar_oferta_productos_modelo()
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM oferta");
        $sql->execute();

        return $sql;
    }

    /*Modelo para eliminar producto */
    protected static function eliminar_producto_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("DELETE FROM producto WHERE idproducto=:ID");
        $sql->bindParam(":ID", $id);
        $sql->execute();

        return $sql;
    }

    /*Modelo para editar clientes */
    protected static function datos_producto_modelo($tipo, $id)
    {
        if ($tipo == "unico") { //seleccionamos los datos de un unico usuario para cargarlo en el formulario
            $sql = mainModel::conectar()->prepare("SELECT * FROM producto WHERE idproducto=:ID");
            $sql->bindParam(":ID", $id);
        } elseif ($tipo == "conteo") {
            $sql = mainModel::conectar()->prepare("SELECT idproducto FROM producto ");
        }

        $sql->execute();
        return $sql;
    }

    /*Modelo para actualizar datos personales del clientes */
    protected static function actualizar_datos_producto_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("UPDATE producto SET nom_product=:nom_product, id_oferta=:id_oferta, id_categoria=:id_categoria,
         detalle=:detalle, precio=:precio, stock=:stock WHERE idproducto=:ID");

        $sql->bindParam(":nom_product", $datos['nombre']);
        $sql->bindParam(":id_oferta", $datos['oferta']);
        $sql->bindParam(":id_categoria", $datos['categoria']);
        $sql->bindParam(":detalle", $datos['detalle']);
        $sql->bindParam(":precio", $datos['precio']);
        $sql->bindParam(":stock", $datos['stock']);
        $sql->bindParam(":ID", $datos['id']);
        $sql->execute();

        return $sql;
    }

    protected static function actualizar_foto_producto_modelo($dato){
        $sql = mainModel::conectar()->prepare("UPDATE producto SET img=:img WHERE idproducto=:ID");

        $sql->bindParam(":img", $dato['img']);
        $sql->bindParam(":ID", $dato['id']);
        $sql->execute();

        return $sql;
    }


    /*Modelo para agregar una nueva categoria de productos */
    protected static function agregar_categoria_producto_modelo($nombre)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO categoria(nombre)
        VALUES(:nombre)");

        $sql->bindParam(":nombre", $nombre);
        $sql->execute();

        return $sql;
    }
    /*Modelo para eliminar una nueva categoria de productos */
    protected static function eliminar_categoria_producto_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("DELETE FROM categoria WHERE id_categoria=:ID");
        $sql->bindParam(":ID", $id);
        $sql->execute();

        return $sql;
    }
    /*Modelo para agregar nueva oferta*/
    protected static function agregar_oferta_producto_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO oferta(codigo,descuento)
        VALUES(:codigo,:descuento)");

        $sql->bindParam(":codigo", $datos['codigo']);
        $sql->bindParam(":descuento", $datos['descuento']);
        $sql->execute();

        return $sql;
    }
    /*Modelo para eliminar una oferta */
    protected static function eliminar_oferta_producto_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("DELETE FROM oferta WHERE id_oferta=:ID");
        $sql->bindParam(":ID", $id);
        $sql->execute();

        return $sql;
    }
}
