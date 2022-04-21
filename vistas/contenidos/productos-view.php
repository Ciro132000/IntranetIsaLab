<div class="container">

    <?php
    require_once "./controladores/productoControlador.php";
    $productos = new productoControlador();
    $lista_productos = $productos->listar_producto_controlador();
    $ins_product = new productoControlador();
    $lista_cat = $ins_product->listar_categoria_productos_controlador();
    $lista_ofer = $ins_product->listar_oferta_productos_controlador();
    $categorias = $ins_product->listar_categoria_productos_controlador();
    $ofertas = $ins_product->listar_oferta_productos_controlador();
    ?>

    <div class="py-4 border-bottom">
        <div class="container">
            <h1 class="text-center">Productos</h1>
            <div class="row">
                <div class="col-lg-3">
                    <button class="btn btn-light w-100 align-self-center" data-toggle="modal" data-target="#Registrar"><i class="fas fa-plus-circle mr-2"></i></i>NUEVO PRODUCTO</button>
                </div>

                <div class="col-lg-3">
                    <button class="btn btn-light w-100 align-self-center" data-toggle="modal" data-target="#RegistrarCategoria"><i class="fas fa-plus-circle mr-2"></i></i>CATEGORIAS</button>
                </div>

                <div class="col-lg-3">
                    <button class="btn btn-light w-100 align-self-center" data-toggle="modal" data-target="#RegistrarOferta"><i class="fas fa-plus-circle mr-2"></i></i>OFERTAS</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive py-5">
        <table id="example" class="table table-striped ">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Foto</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Oferta</th>
                    <th class="text-center">Categoria</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Precio Final</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Modificar</th>
                    <th class="text-center">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista_productos as $lista) { ?>
                    <tr>
                        <th scope="row"><?php echo $lista['0']; ?></th>
                        <td><img src="<?php echo SERVERURL; ?>vistas/img/img_productos/<?php echo $lista['1']; ?>" style="max-height: 40px;"></td>
                        <td><?php echo $lista['2']; ?></td>
                        <td>-%<?php echo $lista['4']; ?></td>
                        <td><?php echo $lista['3']; ?></td>
                        <td>S/.<?php echo $lista['6']; ?></td>
                        <td>S/.
                            <?php
                            $precio_final = $lista['6'] - ($lista['6'] * ($lista['4'] / 100));
                            echo $precio_final;
                            ?>
                        </td>
                        <td><?php echo $lista['7']; ?></td>
                        <td class="d-flex justify-content-center">
                            <a style="font-size: 20px;" href="<?php echo SERVERURL . "productos-modificar/" . $lc->encryption($lista['0']) . "/"; ?>">
                                <i class="fas fa-user-edit "></i>
                            </a>
                        </td>
                        <td>
                            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productosAjax.php" method="POST" data-form="delete" autocomplete="off">
                                <input type="hidden" name="id_product_eliminar" value="<?php echo $lista['0']; ?>">
                                <button type="submit" class="btn align-self-center text-delete"><i class="fas fa-trash-alt "></i></button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!--Nuevo producto-->
    <div class="modal fade" id="Registrar" tabindex="-1" role="dialog" aria-labelledby="Titulo" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="Titulo">Agregar nuevo producto</h5>
                    <button class="close" data-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productosAjax.php" method="POST" data-form="save" autocomplete="off">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="tex" class="form-control" name="nombre_nuevo" id="nombre">
                        </div>
                        <div class="form-group">
                            <label for="foto">Imagen</label>
                            <input type="file" class="form-control" name="foto_nuevo" id="foto" accept=".jpg, .png, .gif">
                        </div>
                        <div class="form-group">
                            <label for="precio">precio</label>
                            <input type="number" step="0.01" min="0.00" class="form-control" name="precio_nuevo" id="precio">
                        </div>
                        <div class="form-group">
                            <label for="categoria">Categoria</label>
                            <select class="form-control" id="categoria" name="categoria_nuevo">
                                <?php foreach ($lista_cat as $categoria) { ?>
                                    <option value="<?php echo $categoria['0']; ?>"><?php echo $categoria['1']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Oferta">Oferta</label>
                            <select class="form-control" id="Oferta" name="oferta">
                                <?php foreach ($lista_ofer as $oferta) { ?>
                                    <option value="<?php echo $oferta['0']; ?>"><?php echo $oferta['1']; ?>-Descuento: -%<?php echo $oferta['2']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Detalle">Detalle</label>
                            <textarea class="form-control" id="Detalle" name="detalle_nuevo" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="Stock">Stock</label>
                            <input type="number" class="form-control" id="Stock" name="stock_nuevo">
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!--CATEGORIAS-->
    <div class="modal fade" id="RegistrarCategoria" tabindex="-1" role="dialog" aria-labelledby="Titulo" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="Titulo">CATEGORIAS</h5>
                    <button class="close" data-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productosAjax.php" method="POST" data-form="save" autocomplete="off">
                        <div class="form-group">
                            <label for="nombre">Nombre de la categoría:</label>
                            <input type="tex" class="form-control" name="nombre_categoria" id="nombre">
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>


                    <div class="table-responsive py-5">
                        <table id="example" class="table table-striped ">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nombre de categoria</th>
                                    <th class="text-center">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categorias as $cat) { ?>
                                    <tr>
                                        <th scope="row"><?php echo $cat['0']; ?></th>
                                        <td><?php echo $cat['1']; ?></td>
                                        <td>
                                            <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productosAjax.php" method="POST" data-form="delete" autocomplete="off">
                                                <input type="hidden" name="id_cat_eliminar" value="<?php echo $cat['0']; ?>">
                                                <button type="submit" class="btn align-self-center text-delete"><i class="fas fa-trash-alt "></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--OFERTAS-->
    <div class="modal fade" id="RegistrarOferta" tabindex="-1" role="dialog" aria-labelledby="Titulo" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="Titulo">OFERTAS</h5>
                    <button class="close" data-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="border-bottom py-2">
                        <form class="FormularioAjax " action="<?php echo SERVERURL; ?>ajax/productosAjax.php" method="POST" data-form="save" autocomplete="off">
                            <h5>Registrar nueva oferta</h5>
                            <div class="form-row lign-items-center">

                                <div class="col">
                                    <input type="tex" class="form-control" name="cod_oferta" placeholder="Codigo de la oferta:">
                                </div>
                                <div class="col">
                                    <input type="tex" class="form-control" name="dsc_oferta" placeholder="% descuento de la oferta">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary">Registrar</button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="py-2">
                        <div class="table-responsive py-5">
                            <table id="example" class="table table-striped ">
                                <thead>
                                    <tr>
                                        <th class="text-center">Codigo Oferta</th>
                                        <th class="text-center">Descuento</th>
                                        <th class="text-center">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ofertas as $ofe) { ?>
                                        <tr>
                                            <th scope="row"><?php echo $ofe['1']; ?></th>
                                            <td>-% <?php echo $ofe['2']; ?></td>
                                            <td>
                                                <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productosAjax.php" method="POST" data-form="delete" autocomplete="off">
                                                    <input type="hidden" name="id_dsc_eliminar" value="<?php echo $ofe['0']; ?>">
                                                    <button type="submit" class="btn align-self-center text-delete"><i class="fas fa-trash-alt "></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>

</div>