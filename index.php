<?php

require_once "./config/APP.php";
require_once "./controladores/vistasControlador.php";

$control = new vistasControlador();

$control->obtener_plantilla_controlador();


 ?>