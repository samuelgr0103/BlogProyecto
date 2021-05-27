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
$query = "SELECT *FROM cursos";

//consultar la BD
$resultadoConsulta = mysqli_query($db, $query);


//Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['idCursos'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if ($id) {
        //Elimina el archivo
        $query = "SELECT imagen FROM cursos where idCursos=${id}";
        $resultado = mysqli_query($db, $query);
        $cursos = mysqli_fetch_assoc($resultado);
        unlink('../../imagenes/' . $cursos['imagen']);

        //Elimina la propiedad
        $query = "DELETE  FROM Cursos WHERE idCursos= ${id}";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('location: /admin?resultado=3');
        }
    }
}

incluirTemplates('header');
?>

<main class="contenedor">
    <h1 class="centrar-texto">Administrador del blog</h1>

    <a href="/admin/index.php" class="boton boton--cafe">Regresar</a>

    <table class="cursos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Capacidad</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!--Mostrar Resultados-->
            <?php while ($cursos = mysqli_fetch_assoc($resultadoConsulta)) : ?>
                <tr>
                    <td><?php echo $cursos['idCursos']; ?></td>
                    <td><?php echo $cursos['nombre']; ?></td>
                    <td><?php echo $cursos['Capacidad']; ?></td>
                    <td><?php echo $cursos['precio']; ?></td>
                    <td><img src="/imagenes/<?php echo $cursos['imagen']; ?>" class="imagen-tabla"></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="idCursos" value="<?php echo $cursos['idCursos'] ?>">
                            <input type="submit" class="boton-negro-block" value="Eliminar">
                        </form>
                        <a class="boton-amarillo-block" href="/admin/propiedades/actualizar.php?id=<?php echo $cursos['idCursos']; ?>">Actializar</a>
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