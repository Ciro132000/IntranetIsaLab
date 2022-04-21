<?php 
    require_once "./modelos/vistasModelo.php";

    class vistasControlador extends vistasModelo{

        /*----Controlador para obtener plantilla----*/

        public function obtener_plantilla_controlador(){
            return require_once "./vistas/plantilla.php";
        }

        /*----Controlador obtener vistas----*/

        public function obtener_vistas_controlador(){
            if(isset($_GET['ruta'])){
                $ruta=explode("/",$_GET['ruta']);
                $respuesta=vistasModelo::obtener_vistas_modelo($ruta[0]);
            }else{
                $respuesta="login";
            }
            return $respuesta;
        }
    }