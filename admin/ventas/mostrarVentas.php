<?php
require '../../include/funciones.php';
$auth = estaAutenticado();
$usuario=$_SESSION['usuario'];
if(!$auth ){
    header('location: /');
}
if($usuario!=='samuelgr62@gmail.com'){
    header('location: /');
}

//Importar la conexion
require '../../include/config/database.php';
$db = conectarDB();
//Escribir en el query

//consultar la BD
$date = date('Y/m/d');
$query = "SELECT *FROM ventas  where fechaVenta='${date}'";
$resultadoConsulta = mysqli_query($db, $query);
$suma = "SELECT SUM(ventaTotal) FROM ventas  where fechaVenta='${date}'";
$resultadoSuma = mysqli_query($db, $suma);
$resultados=mysqli_fetch_assoc($resultadoSuma);

$totalVenta=$resultados['SUM(ventaTotal)'];
$totalVenta=filter_var($totalVenta,FILTER_VALIDATE_FLOAT);

//Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['fecha'];
    $query = "SELECT *FROM ventas  where fechaVenta='${date}'";
    $resultadoConsulta = mysqli_query($db, $query);
    $suma = "SELECT SUM(ventaTotal) FROM ventas  where fechaVenta='${date}'";
    $resultadoSuma = mysqli_query($db, $suma);
    $resultados=mysqli_fetch_assoc($resultadoSuma);
    $totalVenta=$resultados['SUM(ventaTotal)'];
    }

incluirTemplates('header');
?>

<main class="contenedor">
    <h1 class="centrar-texto">Ventas</h1>
    <div class="botones-titulos">
        <a href="/admin/index.php" class="boton boton--cafe">Regresar</a>
        <form action="" method="POST">
            <input type="date" name="fecha" id="fecha" value="<?php echo $date ?>">
            <input type="submit" value="Mostrar" class="boton boton--cafe">
        </form>
    </div>

    <table class="cursos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Descripcion</th>
                <th>Usuario</th>
                <th>Fecha Venta</th>
            </tr>
        </thead>
        <tbody>
            <!--Mostrar Resultados-->
            <?php while ($cursos = mysqli_fetch_assoc($resultadoConsulta)) : ?>
                <tr>
                    <td><?php echo $cursos['idventas']; ?></td>
                    <td><?php echo $cursos['nombreVenta']; ?></td>
                    <td><?php echo $cursos['precioVenta']; ?></td>
                    <td><?php echo $cursos['cantidadVenta']; ?></td>
                    <td><?php echo $cursos['ventaTotal']; ?></td>
                    <td><?php echo $cursos['descripcionVenta']; ?></td>
                    <td><?php echo $cursos['usuario']; ?></td>
                    <td><?php echo $cursos['fechaVenta']; ?></td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div>
        <p class="widget-curso__label">
            Venta Total:
            <span class="widget-curso__info"><?php echo $totalVenta ?></span>
        </p>
        
    </div>
</main>
<?php

//Cerrar la conexion
mysqli_close($db);
incluirTemplates('footer');
?>