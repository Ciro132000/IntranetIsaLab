<?php
if ($peticionAjax) {
    require_once "../modelos/loginModelo.php";
} else {
    require_once "./modelos/loginModelo.php";
}

class loginControlador extends loginModelo
{

    /*Controlador para iniciar sesion */
    public function iniciar_sesion_controlador()
    {
        $usuario = mainModel::limpiar_cadena($_POST['usuario_login']);
        $contrasena = mainModel::limpiar_cadena($_POST['contrasena_login']);

        /*comprobando campos vacios */
        if ($usuario == "" || $contrasena == "") {
            echo
            '<script> 
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "Debe llenar todos los campos",
                    icon: "error",
                    confirmButtonText: "Aceptar"
                });
            </script> ';
            exit();
        }

        $datos_login=[
            "usuario"=>$usuario,
            "contrasena"=>$contrasena
        ];

        $datos_cuenta=loginModelo::inciar_sesion_modelo($datos_login);

        if($datos_cuenta->rowCount()==1){
            $row=$datos_cuenta->fetch();
            session_start(['name'=>'SPM']);

            $_SESSION['id_spm']=$row['idadmin'];
            $_SESSION['nombre_spm']=$row['nombre'];
            $_SESSION['apellido_spm']=$row['apellido'];
            $_SESSION['token_spm']=md5(uniqid(mt_rand(),true));
            return header("location: ".SERVERURL."home/");
        }else{
            echo
            '<script> 
                Swal.fire({
                    title: "Ocurrio un error inesperado",
                    text: "Usuario o contraseña incorrectas",
                    icon: "error",
                    confirmButtonText: "Aceptar"
                });
            </script> ';
        }
    }
    /*Fin controlador */

    /* Controlador para forzar cierre de sesion */
    public function forzar_cierre_sesion_controlador(){
        session_unset();
        session_destroy();
        if(headers_sent()){
            return "<script> window.location.href='".SERVERURL."login/'; </script>";
        }else{
            return header("location: ".SERVERURL."login/");
        }
    }   
    /* Fin controlador */

    /* controlador cerrar sesion */
    public function cierre_sesion_controlador(){
        session_start(['name'=>'SPM']);
        $token=mainModel::decryption($_POST['token']);
        $usuario=mainModel::decryption($_POST['usuario']);

        if($token==$_SESSION['token_spm'] && $usuario==$_SESSION['nombre_spm']){
            session_unset();
            session_destroy();
            $alerta=[
                "Alerta"=>"redireccionar",
                "URL"=>SERVERURL."login/"
            ];
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un problema",
                "Texto"=>"No se pudo cerrar sesion",
                "Tipo"=>"error"
            ];
        }
        echo json_encode($alerta);
            exit();
    }
}
