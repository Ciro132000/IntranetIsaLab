
<?php require_once "./controladores/clienteControlador.php";
require_once "./controladores/productoControlador.php";

$ins_product = new productoControlador();
$totalproductos = $ins_product->datos_productos_controlador("conteo", 0);

$ins_cli = new clienteControlador();
$totalclientes = $ins_cli->datos_clientes_controlador("conteo", 0);
?>
<div class="container">

    <h1 style="color: red;">Bienvenido a la intranet de Isalab Farma</h1>
    <br>
    
    <div class="row d-flex">
        <div class="card mr-2" style="width: 18rem;">
            <div class="card-body">
                <a href="<?php echo SERVERURL; ?>clientes/">
                    <h2 class="text-center" style="font-size: 900%;"><i class="fas fa-address-book"></i></h2>
                    <p><?php echo $totalclientes->rowCount(); ?> clientes estan resgistrados en el sistema.</p>
                </a>
            </div>
        </div>

        <div class="card mr-2" style="width: 18rem;">
            <div class="card-body">
                <a href="<?php echo SERVERURL; ?>productos/">
                    <h2 class="text-center" style="font-size: 900%;"><i class="fas fa-capsules"></i></i></h2>
                    <p><?php echo $totalproductos->rowCount(); ?> productos estan resgistrados en el sistema.</p>
                </a>
            </div>
        </div>
    </div>


</div>