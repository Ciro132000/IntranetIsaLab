<?php
if ($peticionAjax) {
    require_once "../modelos/clienteModelo.php";
} else {
    require_once "./modelos/clienteModelo.php";
}

class clienteControlador extends clienteModelo
{

    /* Controlador para agregar cliente */
    public function agregar_cliente_controlador()
    {
        $nombre = mainModel::limpiar_cadena($_POST['nombre']);
        $apellido = mainModel::limpiar_cadena($_POST['apellido']);
        $dni = mainModel::limpiar_cadena($_POST['dni']);
        $telefono = mainModel::limpiar_cadena($_POST['telefono']);
        $correo = mainModel::limpiar_cadena($_POST['correo']);
        $direccion = mainModel::limpiar_cadena($_POST['direccion']);
        $usuario = mainModel::limpiar_cadena($_POST['usuario']);
        $contrasena = mainModel::limpiar_cadena($_POST['contrasena']);

        /* --Comprobar si hay campos vacios-- */
        if ($nombre == "" || $apellido == "" || $dni == "" || $telefono == "" || $correo == "" || $direccion == "" || $usuario == "" || $contrasena == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Revisa los datos y vuelva a intentarlo",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        /* --verificar integridad de los datos-- */
        if (mainModel::verificar_datos("[0-9-]{8,8}", $dni)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Ingresar un DNI válido",
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

        /* --verificar si el DNI no existe en la base de datos-- */
        $check_dni = mainModel::ejecutar_consulta_simple("SELECT dni FROM usuario WHERE dni='$dni'");
        if ($check_dni->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El DNI ingresado ya se encuentra registrado en el sistema",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        /*== Comprobando usuario ==*/
        $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario FROM usuario WHERE usuario='$usuario'");
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
            "dni" => $dni,
            "telefono" => $telefono,
            "correo" => $correo,
            "direccion" => $direccion,
            "usuario" => $usuario,
            "contrasena" => $contrasena
        ];

        $agregar_usuario = clienteModelo::agregar_cliente_modelo($datos_usuario_reg);

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
    public function listar_cliente_controlador()
    {
        $lista_clientes = clienteModelo::listar_cliente_modelo();
        return $lista_clientes->fetchAll();
    }/*fin controlador*/

    /*Control para eliminar cliente */
    public function eliminar_cliente_controlador()
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
        $check_cliente = mainModel::ejecutar_consulta_simple("SELECT idusuario FROM usuario WHERE idusuario='$id'");
        if ($check_cliente->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "El usuario que intenta eliminar no existe",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        /*Comprobando si usuario tiene deudas o pedidos pendientes*/
        /*$check_deudas=mainModel::ejecutar_consulta_simple("SELECT idusuario FROM usuario WHERE idusuario='$id' LIMIT 1 ");
            if($check_deudas->rowCount()>0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error",
                    "Texto"=>"El usuario no se puede eliminar por que presenta deudas o pedidos",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }*/

        $eliminar_cliente = clienteModelo::eliminar_cliente_modelo($id);

        if ($eliminar_cliente->rowCount() == 1) {
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
    public function datos_clientes_controlador($tipo, $id)
    {
        $tipo = mainModel::limpiar_cadena($tipo);

        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);

        return clienteModelo::datos_clientes_modelo($tipo, $id);
    }/*fin controlador*/

    /*Control para actualizar datos personales del cliente */
    public function actualizar_datos_cliente_controlador()
    {
        $id = mainModel::decryption($_POST['idactualizardatos']);
        $id = mainModel::limpiar_cadena($id);

        /*== Comprobando usuario ==*/
        $check_user = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE idusuario='$id'");
        if ($check_user->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El cliente que intenta modificar no existe",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $nombre = mainModel::limpiar_cadena($_POST['nombre_actu']);
        $apellido = mainModel::limpiar_cadena($_POST['apellido_actu']);
        $dni = mainModel::limpiar_cadena($_POST['dni_actu']);
        $telefono = mainModel::limpiar_cadena($_POST['telefono_actu']);
        $correo = mainModel::limpiar_cadena($_POST['correo_actu']);
        $direccion = mainModel::limpiar_cadena($_POST['direccion_actu']);

        /* --Comprobar si hay campos vacios-- */
        if ($nombre == "" || $apellido == "" || $dni == "" || $telefono == "" || $correo == "" || $direccion == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Revisa los datos y vuelva a intentarlo",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        /* --verificar integridad de los datos-- */
        if (mainModel::verificar_datos("[0-9-]{8,8}", $dni)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Ingresar un DNI válido",
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

        /* --verificar si el DNI no existe en la base de datos-- */
        $check_dni = mainModel::ejecutar_consulta_simple("SELECT dni FROM usuario WHERE dni='$dni'");
        if ($check_dni->rowCount() > 1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El DNI ingresado ya se encuentra registrado en el sistema",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        /* actualizar usuario */
        $datos_usuario_actu = [
            "nombre" => $nombre,
            "apellido" => $apellido,
            "dni" => $dni,
            "telefono" => $telefono,
            "correo" => $correo,
            "direccion" => $direccion,
            "id" => $id
        ];

        if (clienteModelo::actualizar_datos_cliente_modelo($datos_usuario_actu)) {
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
    public function actualizar_acceso_cliente_controlador()
    {
        $id = mainModel::decryption($_POST['id_actualizar_acceso']);
        $id = mainModel::limpiar_cadena($id);

        /*== Comprobando usuario existente ==*/
        $check_user = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE idusuario='$id'");
        if ($check_user->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El cliente que intenta modificar no existe",
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
        $check_user = mainModel::ejecutar_consulta_simple("SELECT usuario FROM usuario WHERE usuario='$usuario'");
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

        if (clienteModelo::actualizar_acceso_cliente_modelo($acceso_usuario_actu)) {
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
