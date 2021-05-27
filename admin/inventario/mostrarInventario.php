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
$query = "SELECT *FROM inventario";

//consultar la BD
$resultadoConsulta = mysqli_query($db, $query);


//Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['idinventario'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if ($id) {
        //Elimina el archivo
        $query = "SELECT imagen FROM inventario where idinventario=${id}";
        $resultado = mysqli_query($db, $query);
        $cursos = mysqli_fetch_assoc($resultado);
        unlink('../../imagenes/' . $cursos['imagen']);

        //Elimina la propiedad
        $query = "DELETE  FROM inventario WHERE idinventario= ${id}";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('location: /admin/inventario/mostrarInventario.php?resultado=3');
        }
    }
}
$resultado=$_GET['resultado']?? null;

incluirTemplates('header');
?>

<main class="contenedor">
    <h1 class="centrar-texto">Inventario</h1>
    <h1 class="centrar-texto">Administrador del blog</h1>
           <?php if(intval($resultado)===1): ?>
              <p class="alerta exito">Producto creado Correctamente</p>
              <?php elseif(intval($resultado)===2): ?>
              <p class="alerta exito">Producto Actualizado Correctamente</p>
              <?php elseif(intval($resultado)===3): ?>
              <p class="alerta exito">Producto Eliminado Correctamente</p>
    
           <?php endif; ?>
    <div class="botones-titulos">
    <a href="/admin/index.php" class="boton boton--cafe">Regresar</a>
    <a href="/admin/inventario/crearInventario.php" class="boton boton--cafe">Agregar Inventario</a>
 </div>

    <table class="cursos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Descripcion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!--Mostrar Resultados-->
            <?php while ($cursos = mysqli_fetch_assoc($resultadoConsulta)) : ?>
                <tr>
                    <td><?php echo $cursos['idinventario']; ?></td>
                    <td><?php echo $cursos['nombreProducto']; ?></td>
                    <td><img src="/imagenes/<?php echo $cursos['imagen']; ?>" class="imagen-tabla"></td>
                    <td><?php echo $cursos['precioInicio']; ?></td>
                    <td><?php echo $cursos['stockInicio']; ?></td>
                    <td><?php echo $cursos['descripcionProducto']; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="idinventario" value="<?php echo $cursos['idinventario'] ?>">
                            <input type="submit" class="boton-negro-block" value="Eliminar">
                        </form>
                        <a class="boton-amarillo-block" href="/admin/inventario/actualizarProducto.php?id=<?php echo $cursos['idinventario']; ?>">Actializar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>
<?php

//Cerrar la conexion
mysqli_close($db);
incluirTemplates('footer');
?>