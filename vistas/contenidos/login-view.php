<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo COMPANY ?></title>
</head>

<body>
    <div class="wrapper">
        <form class="form-signin"  method="POST">
            <h2 class="form-signin-heading">Iniciar Sesion</h2>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario_login" class="form-control" id="usuario">
            </div>
            <div class="mb-3">
                <label for="contraseña" class="form-label">Password</label>
                <input type="password" class="form-control" name="contrasena_login" id="contraseña">
            </div>
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
    </div>

    <style>
        @import "bourbon";

        body {
            background: #eee !important;
        }

        .wrapper {
            margin-top: 80px;
            margin-bottom: 80px;
        }

        .form-signin {
            max-width: 380px;
            padding: 15px 35px 45px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.1);


        }
        .form-control {
                position: relative;
                font-size: 16px;
                height: auto;
                padding: 10px;

            }
    </style>

</body>

</html>


<?php
if (isset($_POST['usuario_login']) && isset($_POST['contrasena_login'])) {
    require_once "./controladores/loginControlador.php";

    $ins_login = new loginControlador();

    echo $ins_login->iniciar_sesion_controlador();
}
?>