<?php 

    require_once "mainModel.php";

    class loginModelo extends mainModel{
        /* Modelo para iniciar sesion */
        protected static function inciar_sesion_modelo($datos){
            $sql=mainModel::conectar()->prepare("SELECT * FROM administradores WHERE usuario=:usuario AND contrasena=:contrasena");
        
            $sql->bindParam(":usuario", $datos['usuario']);
            $sql->bindParam(":contrasena", $datos['contrasena']);
            $sql->execute();

            return $sql;
        }

    }