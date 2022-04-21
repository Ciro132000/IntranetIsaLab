<?php
require_once "mainModel.php";

class administradorModelo extends mainModel
{
    /* Modelo para agregar cliente */
    protected static function agregar_admin_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO administradores(nombre,apellido,usuario,contrasena)
         VALUES(:nombre,:apellido,:usuario,:contrasena)");

        $sql->bindParam(":nombre", $datos['nombre']);
        $sql->bindParam(":apellido", $datos['apellido']);
        $sql->bindParam(":usuario", $datos['usuario']);
        $sql->bindParam(":contrasena", $datos['contrasena']);
        $sql->execute();

        return $sql;
    }

    /*Modelo para listar clientes */
    protected static function listar_admin_modelo()
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM administradores");
        $sql->execute();

        return $sql;
    }
    /*fin Modelo*/

    /*Modelo para eliminar clientes */
    protected static function eliminar_admin_modelo($id)
    {
        $sql = mainModel::conectar()->prepare("DELETE FROM administradores WHERE idadmin=:ID");
        $sql->bindParam(":ID", $id);
        $sql->execute();

        return $sql;
    }

    /*Modelo para editar clientes */
    protected static function datos_admin_modelo($tipo, $id)
    {
        if ($tipo == "unico") { //seleccionamos los datos de un unico usuario para cargarlo en el formulario
            $sql = mainModel::conectar()->prepare("SELECT * FROM administradores WHERE idadmin=:ID");
            $sql->bindParam(":ID", $id);
        } elseif ($tipo == "conteo") {
            $sql = mainModel::conectar()->prepare("SELECT idadmin FROM administradores ");
        }

        $sql->execute();
        return $sql;
    }
    /*Fin modelo*/

    /*Modelo para actualizar datos personales del clientes */
    protected static function actualizar_datos_admin_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("UPDATE administradores SET nombre=:nombre,apellido=:apellido WHERE idadmin=:ID");

        $sql->bindParam(":nombre", $datos['nombre']);
        $sql->bindParam(":apellido", $datos['apellido']);
        $sql->bindParam(":ID", $datos['id']);   

        $sql->execute();

        return $sql;
    }

    /*Modelo para actualizar datos de acceso del clientes */
    protected static function actualizar_acceso_admin_modelo($datos){
        $sql=mainModel::conectar()->prepare("UPDATE administradores SET usuario=:usuario, contrasena=:contrasena WHERE idadmin=:ID");

        $sql->bindParam(":usuario", $datos['usuario']);
        $sql->bindParam(":contrasena", $datos['contrasena']);
        $sql->bindParam(":ID", $datos['ID']);  
        $sql->execute();

        return $sql;
    }
}