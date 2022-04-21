<?php
if ($peticionAjax) {
    require_once "../modelos/administradorModelo.php";
} else {
    require_once "./modelos/administradorModelo.php";
}

class administradorControlador extends administradorModelo
{

    /* Controlador para agregar cliente */
    public function agregar_admin_controlador()
    {
        $nombre = mainModel::limpiar_cadena($_POST['nombre']);
        $apellido = mainModel::limpiar_cadena($_POST['apellido']);
        $usuario = mainModel::limpiar_cadena($_POST['usuario']);
        $contrasena = mainModel::limpiar_cadena($_POST['contrasena']);

        /* --Comprobar si hay campos vacios-- */
        if ($nombre == "" || $apellido == "" || $usuario == "" || $contrasena == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Revisa los datos y vuelva a intentarlo",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $nombre)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Ingresar un nombre válido",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $apellido)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Ingresar un apellido válido",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }


        /*== Comprobando usuario ==*/
        $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario FROM administradores WHERE usuario='$usuario'");
        if ($check_user->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El NOMBRE DE USUARIO ingresado ya se encuentra registrado en el sistema",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        /* Registrando usuario */
        $datos_usuario_reg = [
            "nombre" => $nombre,
            "apellido" => $apellido,
            "usuario" => $usuario,
            "contrasena" => $contrasena
        ];

        $agregar_usuario = administradorModelo::agregar_admin_modelo($datos_usuario_reg);

        if ($agregar_usuario->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "usuario registrado",
                "Texto" => "Los datos del usuario han sido registrados con exito",
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
    }/*Fin controlador */

    /*Controlador para listar clientes */
    public function listar_admin_controlador()
    {
        $lista_admin = administradorModelo::listar_admin_modelo();
        return $lista_admin->fetchAll();
    }/*fin controlador*/

    /*Control para eliminar cliente */
    public function eliminar_admin_controlador()
    {
        $id = $_POST['ideliminar'];
        $id = mainModel::limpiar_cadena($id);

        /*Comprobando usuario principal*/
        if ($id == 1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "No podemos eliminar el usuario principal",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        /*Comprobando usuario en DB*/
        $check_admin = mainModel::ejecutar_consulta_simple("SELECT idadmin FROM administradores WHERE idadmin='$id'");
        if ($check_admin->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "El usuario que intenta eliminar no existe",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_admin = administradorModelo::eliminar_admin_modelo($id);

        if ($eliminar_admin->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Usuario eliminado",
                "Texto" => "",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "No se pudo eliminar el usuario, por favor intente más tarde",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
        exit();
    }/*fin controlador*/

    /*Control para editar cliente */
    public function datos_admin_controlador($tipo, $id)
    {
        $tipo = mainModel::limpiar_cadena($tipo);

        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);

        return administradorModelo::datos_admin_modelo($tipo,$id);
    }/*fin controlador*/

    /*Control para actualizar datos personales del cliente */
    public function actualizar_datos_admin_controlador()
    {
        $id = mainModel::decryption($_POST['idactualizardatos']);
        $id = mainModel::limpiar_cadena($id);

        /*== Comprobando usuario ==*/
        $check_user = mainModel::ejecutar_consulta_simple("SELECT * FROM administradores WHERE idadmin='$id'");
        if ($check_user->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El administrador que intenta modificar no existe",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $nombre = mainModel::limpiar_cadena($_POST['nombre_actu']);
        $apellido = mainModel::limpiar_cadena($_POST['apellido_actu']);

        /* --Comprobar si hay campos vacios-- */
        if ($nombre == "" || $apellido == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Revisa los datos y vuelva a intentarlo",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }


        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $nombre)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Ingresar un nombre válido",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if (mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}", $apellido)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Ingresar un apellido válido",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }


        /* actualizar usuario */
        $datos_usuario_actu = [
            "nombre" => $nombre,
            "apellido" => $apellido,
            "id" => $id
        ];

        if (administradorModelo::actualizar_datos_admin_modelo($datos_usuario_actu)) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Usuario actualizado",
                "Texto" => "Los datos del usuario han sido actualizados con exito",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos podido actualizar los datos del usuario",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }/*fin controlador*/

    /*Control para actualizar acceso del cliente */
    public function actualizar_acceso_admin_controlador()
    {
        $id = mainModel::decryption($_POST['id_actualizar_acceso']);
        $id = mainModel::limpiar_cadena($id);

        /*== Comprobando usuario existente ==*/
        $check_user = mainModel::ejecutar_consulta_simple("SELECT * FROM administradores WHERE idadmin='$id'");
        if ($check_user->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El administrador que intenta modificar no existe",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $campos=$check_user->fetch();
        }
        
        $usuario = mainModel::limpiar_cadena($_POST['usuario_actualizar']);  
        $contrasena = mainModel::limpiar_cadena($_POST['contrasena_actualizar']);

        /* --Comprobar si hay campos vacios-- */
        if ($usuario == "" && $contrasena == "" ) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Rellene almenos un campo",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }
        
        if ($usuario == "") {
            $usuario=$campos['usuario'];   
        }

        if ($contrasena == "") {
            $contrasena=$campos['contrasena'];      
        }

        /*== Comprobando si el nuevo nombre de usuario ya esta en uso ==*/
        $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario FROM administradores WHERE usuario='$usuario'");
        if ($check_user->rowCount() > 1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El nombre de USUARIO ingresado ya se encuentra registrado en el sistema",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }


        /* actualizar usuario */
        $acceso_usuario_actu = [
            "usuario" => $usuario,
            "contrasena" => $contrasena,
            "ID" => $id
        ];

        if (administradorModelo::actualizar_acceso_admin_modelo($acceso_usuario_actu)) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Usuario actualizado",
                "Texto" => "Los datos de acceso del usuario han sido actualizados con exito",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No hemos podido actualizar los datos del usuario",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    }/*fin controlador*/
}
