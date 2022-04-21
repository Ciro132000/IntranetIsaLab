<div class="container">


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

    <div class="table-responsive py-5">
        <table id="example" class="table table-striped ">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Apellido</th>
                    <th class="text-center">DNI</th>
                    <th class="text-center">Telefono</th>
                    <th class="text-center">Correo</th>
                    <th class="text-center">Direccion</th>
                    <th class="text-center">Modificar</th>
                    <th class="text-center">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista_clientes as $lista) { ?>
                    <tr>
                        <th scope="row"><?php echo $lista['0']; ?></th>
                        <td><?php echo $lista['1']; ?></td>
                        <td><?php echo $lista['2']; ?></td>
                        <td><?php echo $lista['3']; ?></td>
                        <td><?php echo $lista['4']; ?></td>
                        <td><?php echo $lista['5']; ?></td>
                        <td><?php echo $lista['6']; ?></td>
                        <td class="d-flex justify-content-center">
                            <a style="font-size: 20px;" href="<?php echo SERVERURL . "clientes-modificar/" . $lc->encryption($lista['0']) . "/"; ?>" >
                                <i class="fas fa-user-edit "></i>
                            </a>
                        </td>
                        <td>
                            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/clienteAjax.php" method="POST" data-form="delete" autocomplete="off">
                                <input type="hidden" name="ideliminar" value="<?php echo $lista['0']; ?>">
                                <button type="submit" class="btn align-self-center text-delete"><i class="fas fa-trash-alt "></i></button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
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