<?php
require 'include/funciones.php';
incluirTemplates('header');
require 'include/config/database.php';
$db = conectarDB();
$consulta = "SELECT *FROM inventario";
$resultadosConsulta = mysqli_query($db, $consulta);
$id = "";
$resultados = $_GET['resultado'] ?? null;
//$auth=estaAutenticado();
//Arreglo con mensajes de errores
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $capacidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $id = $_POST['idinventario'];
    $capacidad = filter_var($capacidad, FILTER_VALIDATE_INT);
    $precio = filter_var($precio, FILTER_VALIDATE_FLOAT);
    if (!$capacidad) {
        $errores[] = "No has seleccionado la cantidad";
    }
    if ($capacidad > $_POST['idcantidad']) {
        $errores[] = "La cantidad es mayor al inventario";
    }
    if ($_SESSION) {
        if (!$_SESSION['login']) {
            $errores[] = "Inicia sesion para poder comprar";
        } else {
            $idcliente = $_SESSION['idcliente'];
            if ($capacidad and empty($error)) {
                $consultacantidad = "select *from carrito where idinventario=${id}";
                $resultado = mysqli_query($db, $consultacantidad);
                //         var_dump($resultado->num_rows); 
                $total = $capacidad * $precio;
                if ($resultado->num_rows) {
                    $consulta = "UPDATE carrito set cantidadProducto=${capacidad},totalVenta=${total} where idinventario=${id}";
                } else {
                    $consulta = "INSERT INTO carrito(idcliente,idinventario,cantidadProducto,totalVenta) values('$idcliente','$id','$capacidad','$total')";
                }
                //   var_dump($consulta);
                mysqli_query($db, $consulta);
            }
                }
    } else {
        $errores[] = "Inicia sesion para poder comprar";
    }

    //Consultar
    $venta = [];
}


?>

<div class="contenedor contenido-tienda">
    <main class="blog centrar-texto">
        <h3>Tienda Blog</h3>
        <?php if (intval($resultados) === 1) : ?>
            <p class="alerta exito">Producto creado Correctamente</p>
        <?php elseif (intval($resultados) === 2) : ?>
            <p class="alerta exito">Compra Realizada</p>
        <?php elseif (intval($resultados) === 3) : ?>
            <p class="alerta exito">Producto Eliminado Correctamente</p>

        <?php endif; ?>
        <?php foreach ($errores as $error) : ?>
            <div class="alerta error"><?php echo $error; ?></div>
        <?php endforeach ?>


        <?php while ($inventario = mysqli_fetch_assoc($resultadosConsulta)) : ?>
            <article class="entrada-tienda">
                <form method="POST">

                    <div class="entrada__contenido">
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
                                    <span class="widget-curso__info"><?php echo $inventario['precioInicio']; ?></span>
                                </p>
                            </li>
                            <li>
                                <input name="idcantidad" type="hidden" value="<?php echo $stock = $inventario['stockInicio']; ?>">

                                <input value="" name="cantidad" type="number" min="0" max="<?php echo $stock = $inventario['stockInicio']; ?>">
                            </li>
                        </ul>
                        <div class="formulario-ventas">
                            <input name="idinventario" type="hidden" value="<?php echo $id = $inventario['idinventario']; ?>">
                            <input name="precio" type="hidden" value="<?php echo $precio = $inventario['precioInicio']; ?>">

                            <input type="submit" class="boton boton--secundario" value="Añadir al carrito">
                            <a href="ventas.php" class="boton boton--secundario">Comprar</a>

                        </div>

                </form>

</div>
</article>
<?php endwhile; ?>

</main>

</div>
<?php

//Cerrar la conexion
mysqli_close($db);
incluirTemplates('footer');
?>