<?php
require_once "mainModel.php";

class clienteModelo extends mainModel
{
    /* Modelo para agregar cliente */
    protected static function agregar_cliente_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO usuario(nombre,apellido,dni,telefono,correo,direccion,usuario,contrasena)
         VALUES(:nombre,:apellido,:dni,:telefono,:correo,:direccion,:usuario,:contrasena)");

        $sql->bindParam(":nombre", $datos['nombre']);
        $sql->bindParam(":apellido", $datos['apellido']);
        $sql->bindParam(":dni", $datos['dni']);
        $sql->bindParam(":telefono", $datos['telefono']);
        $sql->bindParam(":correo", $datos['correo']);
        $sql->bindParam(":direccion", $datos['direccion']);
        $sql->bindParam(":usuario", $datos['usuario']);
        $sql->bindParam(":contrasena", $datos['contrasena']);
        $sql->execute();

        return $sql;
    }

    /*Modelo para listar clientes */
    protected static function listar_cliente_modelo()
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM usuario");
        $sql->execute();

        return $sql;
    }
    /*fin Modelo*/

    /*Modelo para eliminar clientes */
    protected static function eliminar_cliente_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("DELETE FROM usuario WHERE idusuario=:ID");
        $sql->bindParam(":ID", $id);
        $sql->execute();

        return $sql;
    }

    /*Modelo para editar clientes */
    protected static function datos_clientes_modelo($tipo, $id)
    {
        if ($tipo == "unico") { //seleccionamos los datos de un unico usuario para cargarlo en el formulario
            $sql = mainModel::conectar()->prepare("SELECT * FROM usuario WHERE idusuario=:ID");
            $sql->bindParam(":ID", $id);
        } elseif ($tipo == "conteo") {
            $sql = mainModel::conectar()->prepare("SELECT idusuario FROM usuario ");
        }

        $sql->execute();
        return $sql;
    }
    /*Fin modelo*/

    /*Modelo para actualizar datos personales del clientes */
    protected static function actualizar_datos_cliente_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("UPDATE usuario SET nombre=:nombre,apellido=:apellido,dni=:dni,
        telefono=:telefono,correo=:correo,direccion=:direccion WHERE idusuario=:ID");

        $sql->bindParam(":nombre", $datos['nombre']);
        $sql->bindParam(":apellido", $datos['apellido']);
        $sql->bindParam(":dni", $datos['dni']);
        $sql->bindParam(":telefono", $datos['telefono']);
        $sql->bindParam(":correo", $datos['correo']);
        $sql->bindParam(":direccion", $datos['direccion']);
        $sql->bindParam(":ID", $datos['id']);   

        $sql->execute();

        return $sql;
    }

    /*Modelo para actualizar datos de acceso del clientes */
    protected static function actualizar_acceso_cliente_modelo($datos){
        $sql=mainModel::conectar()->prepare("UPDATE usuario SET usuario=:usuario, contrasena=:contrasena WHERE idusuario=:ID");

        $sql->bindParam(":usuario", $datos['usuario']);
        $sql->bindParam(":contrasena", $datos['contrasena']);
        $sql->bindParam(":ID", $datos['ID']);  
        $sql->execute();

        return $sql;
    }
}
