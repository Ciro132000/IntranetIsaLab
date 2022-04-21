<div class="container">

    <?php
    require_once "./controladores/clienteControlador.php";
    $ins_cliente = new clienteControlador();
    $datos_cli = $ins_cliente->datos_clientes_controlador("unico", $paginas[1]);
    $campos = $datos_cli->fetch();
    ?>

    <div class="py-4 border-bottom">
        <h1 class="text-center">Clientes</h1>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <button class="btn btn-light w-100 align-self-center" data-toggle="modal" data-target="#Registrar"><i class="fas fa-plus-circle mr-2"></i></i>NUEVO
                        CLIENTE</button>
                </div>

            </div>
        </div>
    </div>

    <div class="row py-4">
        <div class="col-lg-6 col-sm-12">

            <h5 class="text-center">Actualizar datos personales</h5>

            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/clienteAjax.php" method="POST" data-form="update" autocomplete="off">
                <input type="hidden" name="idactualizardatos" value="<?php echo $paginas[1]; ?>">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="tex" class="form-control" name="nombre_actu" id="nombre" value="<?php echo $campos['nombre'] ?>">
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="tex" class="form-control" name="apellido_actu" id="apellido" value="<?php echo $campos['apellido'] ?>">
                </div>
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="tex" class="form-control" name="dni_actu" id="dni" value="<?php echo $campos['dni'] ?>">
                </div>
                <div class="form-group">
                    <label for="telefono">Telefono</label>
                    <input type="tel" class="form-control" name="telefono_actu" id="telefono" value="<?php echo $campos['telefono'] ?>">
                </div>
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo_actu" value="<?php echo $campos['correo'] ?>">
                </div>
                <div class="form-group">
                    <label for="direccion">Direccion</label>
                    <input type="tex" class="form-control" name="direccion_actu" id="direccion" value="<?php echo $campos['direccion'] ?>">
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>

        </div>
        <div class="col-lg-6 col-sm-12">
            <h5 class="text-center">Actualizar usuario y contraseña</h5>
            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/clienteAjax.php" method="POST" data-form="update" autocomplete="off">
                <input type="hidden" name="id_actualizar_acceso" value="<?php echo $paginas[1]; ?>">
                <div class="form-group">
                    <label for="usuario">Nuevo usuario</label>
                    <input type="tex" class="form-control" name="usuario_actualizar" id="usuario">
                </div>
                <div class="form-group">
                    <label for="contrasena">Nueva contraseña</label>
                    <input type="text" class="form-control" id="contrasena" name="contrasena_actualizar">
                    <small>Puede actualizar el usuario o la contraseña, en su defecto puede actulizar ambos si lo desea.</small>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>

    <div class="py-5">
        <a style="font-size: 25px;" href="<?php echo SERVERURL; ?>clientes/">
            <i class="fas fa-undo-alt"></i> volver átras
        </a>
    </div>

    <!--Nuevo cliente-->
    <div class="modal fade" id="Registrar" tabindex="-1" role="dialog" aria-labelledby="Titulo" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="Titulo">Agregar nuevo empleado</h5>
                    <button class="close" data-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/clienteAjax.php" method="POST" data-form="save" autocomplete="off">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="tex" class="form-control" name="nombre" id="nombre">
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="tex" class="form-control" name="apellido" id="apellido">
                        </div>
                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input type="tex" class="form-control" name="dni" id="dni">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Telefono</label>
                            <input type="tel" class="form-control" name="telefono" id="telefono">
                        </div>
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo">
                        </div>
                        <div class="form-group">
                            <label for="direccion">Direccion</label>
                            <input type="tex" class="form-control" name="direccion" id="direccion">
                        </div>
                        <div class="form-group">
                            <label for="usuario">Usuario</label>
                            <input type="tex" class="form-control" name="usuario" id="usuario">
                        </div>
                        <div class="form-group">
                            <label for="contrasena">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena">
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>

                </div>

            </div>
        </div>
    </div>


</div>