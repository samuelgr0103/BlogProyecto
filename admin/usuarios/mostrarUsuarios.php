<?php
require '../../include/funciones.php';
$auth=estaAutenticado();
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
$query="select *from usuarios,clientes where usuarios.idcliente=clientes.idcliente;";

//consultar la BD
$resultadoConsulta=mysqli_query($db,$query);


//Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if($_SERVER['REQUEST_METHOD']==='POST'){
    $id=$_POST['idusuarios'];
    $id=filter_var($id,FILTER_VALIDATE_INT);
    if($id){
        //Elimina el archivo
        
        //Elimina la propiedad
        $query ="DELETE  FROM usuarios WHERE idusuarios= ${id}";
        $resultado=mysqli_query($db,$query);

        if($resultado){
            header('location: /admin?resultado=3');
        }
    }

}

incluirTemplates('header');
?>

<main class="contenedor">
    <h1 class="centrar-texto">Administrador de Usuarios</h1>

    <a href="/admin/index.php" class="boton boton--cafe">Regresar</a>

    <table class="cursos centrar-texto">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody><!--Mostrar Resultados-->
        <?php while($cursos=mysqli_fetch_assoc($resultadoConsulta)): ?>
            <tr>
                <td><?php echo$cursos['idusuarios']; ?></td>
                <td><?php echo$cursos['nombre']; ?></td>
                <td><?php echo$cursos['apellido']; ?></td>
                <td><?php echo$cursos['email']; ?></td>
                <td>
                    <form method="POST" class="w-100 centrar-texto">
                    <input type="hidden" name="idusuarios" value="<?php echo $cursos['idusuarios'] ?>">
                    <input type="submit" class="boton-negro-block" value="Eliminar">
                    </form>
                    <a class="boton-amarillo-block" href="/admin/usuarios/actualizarUsuarios.php?id=<?php echo$cursos['idcliente']; ?>">Actializar</a>
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