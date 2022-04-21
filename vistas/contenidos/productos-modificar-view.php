<div class="container">
    <?php
    require_once "./controladores/productoControlador.php";
    $ins_prod = new productoControlador();
    $datos_producto = $ins_prod->datos_productos_controlador("unico", $paginas[1]);
    $campos = $datos_producto->fetch();
    $lista_cat = $ins_prod->listar_categoria_productos_controlador();
    $lista_ofer = $ins_prod->listar_oferta_productos_controlador();
    $categorias = $ins_prod->listar_categoria_productos_controlador();
    $ofertas = $ins_prod->listar_oferta_productos_controlador();
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


    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productosAjax.php" method="POST" data-form="update" autocomplete="off">
        <input type="hidden" name="idproductoactu" value="<?php echo $paginas[1]; ?>">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="tex" class="form-control" name="nombre_actu_prod" id="nombre" value="<?php echo $campos['nom_product'] ?>">
        </div>
        <div class="form-group">
            <label for="precio">precio</label>
            <input type="number" step="0.01" min="0.00" class="form-control" name="precio_actu" id="precio" value="<?php echo $campos['precio'] ?>">
        </div>
        <div class="form-group">
            <label for="categoria">Categoria</label>
            <select class="form-control" id="categoria" name="categoria_actu">
                <?php foreach ($lista_cat as $categoria) {
                    if ($campos['id_categoria'] == $categoria['0']) { ?>
                        <option value="<?php echo $categoria['0']; ?>" <?php echo 'selected=""'; ?>><?php echo $categoria['1']; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $categoria['0']; ?>"><?php echo $categoria['1']; ?></option>
                <?php  }
                } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Oferta">Oferta</label>
            <select class="form-control" id="Oferta" name="oferta_actu">
                <?php foreach ($lista_ofer as $oferta) {
                    if ($campos['id_oferta'] == $oferta['0']) { ?>
                        <option value="<?php echo $oferta['0']; ?>" <?php echo 'selected=""'; ?>><?php echo $oferta['1']; ?>-Descuento: -%<?php echo $oferta['2']; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $oferta['0']; ?>"><?php echo $oferta['1']; ?>-Descuento: -%<?php echo $oferta['2']; ?></option>
                <?php }
                } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Detalle">Detalle</label>
            <textarea class="form-control" id="Detalle" name="detalle_actu" rows="3"><?php echo $campos['detalle'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="Stock">Stock</label>
            <input type="number" class="form-control" id="Stock" name="stock_actu" value="<?php echo $campos['stock'] ?>">
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>

    <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/productosAjax.php" method="POST" data-form="update" autocomplete="off">
    <input type="hidden" name="id_foto_actu" value="<?php echo $paginas[1]; ?>">
    <input type="hidden" name="foto_nombre" value="<?php echo $campos['nom_product'] ?>">
        <div class="form-group ">
            <label for="foto">Imagen</label>
            <img class="p-2" src="<?php echo SERVERURL; ?>vistas/img/img_productos/<?php echo $campos['img']; ?>" style="max-height: 90px;">
            <input type="file" class="form-control" name="foto_actu" id="foto" accept=".jpg, .png, .gif">
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>


        <!--Nuevo cliente-->
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
                    <h5 id="Titulo">CATEGORIAS</h5>
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
                                    <input type="tex" class="form-control" name="cod_oferta" placeholder="% descuento de la oferta">
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
                                                    <input type="hidden" name="id_cat_eliminar" value="<?php echo $ofe['0']; ?>">
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