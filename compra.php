<?php
require 'include/funciones.php';
incluirTemplates('header');
?>

<div class="contenedor contenido-tienda">
    <main class="blog centrar-texto">
        <h3>Comprar</h3>


        <?php
        require 'include/config/database.php';
        $db = conectarDB();
        $idcliente = $_SESSION['idcliente'];
        $ventaTotal = 0;
        $ventaTotal = filter_var($ventaTotal, FILTER_VALIDATE_INT);
        $fecha = date('Y/m/d');
        $idcliente = filter_var($idcliente, FILTER_VALIDATE_INT);
        $consultaCarrito = "insert into ventas (nombreVenta,precioVenta,cantidadVenta,descripcionVenta,usuario,fechaVenta,ventaTotal) select nombreProducto,precioInicio,cantidadProducto,descripcionProducto,${idcliente},'${fecha}',totalVenta from inventario,carrito where carrito.idinventario=inventario.idinventario and idcliente=${idcliente}";
           $resultadosConsulta = mysqli_query($db, $consultaCarrito);

        $select = "select *from inventario,carrito where carrito.idinventario=inventario.idinventario and idcliente=${idcliente}";
        $cliente = mysqli_query($db, $select);

        while ($inventario = mysqli_fetch_assoc($cliente)) :
            $idInventario = "";

            $idInventario = $inventario['idinventario'];
            $cantidad = filter_var($inventario['stockInicio'], FILTER_VALIDATE_INT);
            $cantidadRestar = filter_var($inventario['cantidadProducto'], FILTER_VALIDATE_INT);
            $cantidadTotal = 0;
            $cantidadTotal = $cantidad - $cantidadRestar;
//            echo "<pre>";
          //  var_dump($cantidadTotal);
  //          echo "</pre>";
            $update = "UPDATE inventario set stockInicio=${cantidadTotal} WHERE idinventario=${idInventario}";
            var_dump($update);
            mysqli_query($db,$update);

        endwhile;
        $borrar = "DELETE from carrito where idcliente=${idcliente}";
              mysqli_query($db,$borrar);
            header('location: /tiendaBlog.php?resultado=2');

        ?>


    </main>

</div>
<?php

//Cerrar la conexion
mysqli_close($db);

incluirTemplates('footer');
?>