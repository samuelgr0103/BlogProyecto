<?php
require 'include/funciones.php';
incluirTemplates('header');
require 'include/config/database.php';
$db = conectarDB();


if(!$_SESSION){
    header('location: /tiendaBlog.php');
}
?>

<div class="contenedor contenido-tienda">
    <main class="blog centrar-texto">
        <h3>Carrito</h3>


        <?php
        //        estaAutenticado();
        $idcliente = $_SESSION['idcliente'];
        $ventaTotal = 0;
        $ventaTotal = filter_var($ventaTotal, FILTER_VALIDATE_INT);
        //        var_dump($_SESSION);
        $idcliente = filter_var($idcliente, FILTER_VALIDATE_INT);
        $consultaCarrito = "select *from inventario,carrito where carrito.idinventario=inventario.idinventario and idcliente=${idcliente}";
        $resultadosConsulta = mysqli_query($db, $consultaCarrito);
//        $compra = 1;
  //      $id = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['idinventario'];
                $consultaEliminar = "DELETE FROM carrito where idinventario=${id}";
                mysqli_query($db, $consultaEliminar);
                header('location: /ventas.php');
            }



        ?>

        <?php while ($inventario = mysqli_fetch_assoc($resultadosConsulta)) : ?>
            <article class="entrada-tienda">

                <div class="entrada__contenido tienda">
                    <h4 class="no-margin"> <?php echo $inventario['nombreProducto']; ?></h4>

                    <div class="imagentienda">
                        <img loading="lazy" src="/imagenes/<?php echo $inventario['imagen']; ?>" alt="imagen blog" />
                    </div>
                    <p class="just">
                        <?php echo $inventario['descripcionProducto']; ?>
                    </p>
                    <ul>
                        <li class="widget-curso">
                            <p class="widget-curso__label">
                                Precio:
                                <span class="widget-curso__info"><?php echo $precio = $inventario['precioInicio']; ?></span>
                            </p>
                        </li>
                        <li class="widget-curso">
                            <p class="widget-curso__label">
                                Cantidad:
                                <span class="widget-curso__info"><?php echo $cant = $inventario['cantidadProducto']; ?></span>
                            </p>
                        </li>
                        <li class="widget-curso">
                            <p class="widget-curso__label">
                                Total:
                                <span class="widget-curso__info"><?php
                                $total = $cant * $precio;
                                $ventaTotal += $total;
                                echo $total ?></span>
                            </p>
                        </li>

                    </ul>
                    <form method="POST">
                        <input type="hidden" name="idinventario" value="<?php echo $inventario['idinventario'] ?: ''; ?>">
                        <input type="submit" class="boton boton--secundario" value="Eliminar">
                    </form>
                    <br>
                </div>
            </article>
        <?php endwhile; ?>
        <div class="total">
            <p class="widget-curso__label">
                Total:
                <span class="widget-curso__info">
                    <?php
                    echo $ventaTotal ?></span>
            </p>

            <a href="compra.php" class="boton boton-cafe-block">Comprar</a>
        </div>

    </main>

</div>
<?php

//Cerrar la conexion
mysqli_close($db);

incluirTemplates('footer');
?>