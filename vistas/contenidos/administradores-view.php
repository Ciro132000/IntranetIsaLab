<div class="container">


    <div class="py-4 border-bottom">
    <h1 class="text-center">Administradores</h1>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <button class="btn btn-light w-100 align-self-center" data-toggle="modal" data-target="#Registrar"><i class="fas fa-plus-circle mr-2"></i></i>NUEVO
                        ADMINISTRADOR</button>
                </div>

            </div>
        </div>
    </div>

    <div class="table-responsive py-5">
        <table id="example" class="table table-striped ">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Apellido</th>
                    <th class="text-center">Usuario</th>
                    <th class="text-center">Editar</th>
                    <th class="text-center">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista_admin as $admins) { ?>
                    <tr>
                        <th scope="row"><?php echo $admins['0']; ?></th>
                        <td><?php echo $admins['1']; ?></td>
                        <td><?php echo $admins['2']; ?></td>
                        <td><?php echo $admins['3']; ?></td>
                        <td class="d-flex justify-content-center">
                            <a style="font-size: 20px;" href="<?php echo SERVERURL . "administradores-modificar/" . $lc->encryption($admins['0']) . "/"; ?>" >
                                <i class="fas fa-user-edit "></i>
                            </a>
                        </td>
                        <td>
                            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/adminAjax.php" method="POST" data-form="delete" autocomplete="off">
                                <input type="hidden" name="ideliminar" value="<?php echo $admins['0']; ?>">
                                <button type="submit" class="btn align-self-center text-delete"><i class="fas fa-trash-alt "></i></button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!--Nuevo admin-->
    <div class="modal fade" id="Registrar" tabindex="-1" role="dialog" aria-labelledby="Titulo" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="Titulo">Agregar nuevo administrador</h5>
                    <button class="close" data-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/adminAjax.php" method="POST" data-form="save" autocomplete="off">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="tex" class="form-control" name="nombre" id="nombre">
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="tex" class="form-control" name="apellido" id="apellido">
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