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

//Conectar a la base
require '../../include/config/database.php';
$db = conectarDB();


//Validar id
$id=$_GET['id'];
$id=filter_var($id,FILTER_VALIDATE_INT);

if(!$id){
  header('Location: /admin');
}
$consulta="SELECT *FROM clientes where idcliente=${id}";
$resultadoConsulta=mysqli_query($db,$consulta);
$cursos=mysqli_fetch_assoc($resultadoConsulta);

//echo "<pre>";
//var_dump($cursos);
//echo "</pre>";


//Consultar para obtener los vendedores
$consulta="SELECT *FROM usuarios where idcliente='${id}'";
$resultados=mysqli_query($db,$consulta);
$consultaUsuario=mysqli_fetch_assoc($resultados);
$email=$consultaUsuario['email'];
//Arreglo con mensajes de errores
$errores = [];

$nombre = $cursos['nombre'];
$apellido = $cursos['apellido'];

//Ejecutar el codigo despues de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //   echo "<pre>";
    //   var_dump($_POST);
    // echo "</pre>";
    
//exit;

  $nombre =mysqli_real_escape_string($db, $_POST['nombre']);
  $apellido =mysqli_real_escape_string($db, $_POST['apellido']);
  $email =mysqli_real_escape_string($db, $_POST['email']);
    //Asignar file hacia una variables

   
    if (!$nombre) {
        $errores[] = "Debes añadir el nombre";
    }
    if (!$apellido) {
        $errores[] = "Debes añadir el apellido";
    }
    if (!$email) {
        $errores[] = "Debes añadir el E-mail";
    }

    


    //echo "<pre>";
    //var_dump($errores);
    //echo "</pre>";
    //Resivsar que el arreglo de errores esta vacio
    if (empty($errores)) {

        //*Sibida de archivos */
        //Crear carpeta

        //Ingresar a la base de datos
        $query = "UPDATE clientes SET nombre='${nombre}',apellido='${apellido}' where idcliente=${id}";
       echo $query;
        $resultado = mysqli_query($db, $query);
        $query = "UPDATE usuarios SET email='${email}' where idcliente=${id}";


        if ($resultado) {
            //Redireccionar al usuario
            header('Location: /admin?resultado=2');
        }
        
    }
}

incluirTemplates('header');
?>

<main class="contenedor">
    <h3 class="centrar-texto">Actualizar</h3>
    <a href="/admin/propiedades/mostrar.php" class="boton boton--primario">Volver</a>
    <br>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error"><?php echo $error; ?></div>
    <?php endforeach ?>
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Ingresar Curso</legend>
            <label for="nombre">Nombre: </label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo $nombre ?>">
            <label for="apellido">Apellido: </label>
            <input type="text" id="apellido" name="apellido" placeholder="Apellido" value="<?php echo $apellido ?>">
            <label for="email">E-mail: </label>
            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $email ?>">


        </fieldset>
        <br>
        <input type="submit" value="Actualizar Usuario" class="boton boton--secundario">
    </form>
</main>
<?php
incluirTemplates('footer');
?>