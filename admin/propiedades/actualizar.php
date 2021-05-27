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
$consulta="SELECT *FROM cursos where idCursos=${id}";
$resultadoConsulta=mysqli_query($db,$consulta);
$cursos=mysqli_fetch_assoc($resultadoConsulta);

//echo "<pre>";
//var_dump($cursos);
//echo "</pre>";


//Consultar para obtener los vendedores
$consulta="SELECT *FROM maestro";
$resultados=mysqli_query($db,$consulta);


//Arreglo con mensajes de errores
$errores = [];

$nombre = $cursos['nombre'];
$capacidad = $cursos['Capacidad'];
$precio = $cursos['precio'];
$descripcion = $cursos['descripcion'];
$maestro = $cursos['idMaestro'];
$fechaCurso=$cursos['fechaCurso'];
$imagenCurso=$cursos['imagen'];;

//Ejecutar el codigo despues de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //   echo "<pre>";
    //   var_dump($_POST);
    // echo "</pre>";
    
//exit;

  $nombre =mysqli_real_escape_string($db, $_POST['nombre']);
  $capacidad = mysqli_real_escape_string($db, $_POST['capacidad']);
    $precio =mysqli_real_escape_string($db, $_POST['precio']) ;
    $descripcion =mysqli_real_escape_string($db, $_POST['descripcion']) ;
    $fechaCurso=mysqli_real_escape_string($db, $_POST['fecha']);
    $maestro =mysqli_real_escape_string($db,$_POST['maestro']);
    //Asignar file hacia una variables
    $imagen=$_FILES['imagen'];

   
    if (!$nombre) {
        $errores[] = "Debes añadir el nombre del curso";
    }
    if (!$capacidad) {
        $errores[] = "Debes añadir la capacidad del curso";
    }
    if (!$precio) {
        $errores[] = "Debes añadir el precio del curso";
    }
    if (!$fechaCurso) {
        $errores[] = "Debes añadir la fecha del curso";
    }
    if (strlen($descripcion) < 20) {
        $errores[] = "La descripcion es obligatoria y debe tener mas de 20 caracteres";
    }
    if (!$maestro) {
        $errores[] = "Elige un maestro";
    }

    //Validar tamano
    $medida=1000*1000;
    if($imagen['size']>$medida){
        $errores[]='La imagen es muy pesada';
    }
    


    //echo "<pre>";
    //var_dump($errores);
    //echo "</pre>";
    //Resivsar que el arreglo de errores esta vacio
    if (empty($errores)) {

        //*Sibida de archivos */
        //Crear carpeta
        $carpetaImagenes='../../imagenes/';
        
        if(!is_dir($carpetaImagenes)){
            mkdir($carpetaImagenes);
        }
        $nombreImagem='';
        
        if($imagen['name']){
          unlink($carpetaImagenes.$cursos['imagen']);
        //generando nombre aleatorio
        $nombreImagem=md5(uniqid(rand(),true)).'.jpg';

        move_uploaded_file($imagen['tmp_name'],$carpetaImagenes.$nombreImagem);

        }else{
          $nombreImagem=$cursos['imagen'];
        }
        


        //Ingresar a la base de datos
        $query = "UPDATE cursos SET nombre='${nombre}',Capacidad=${capacidad},precio=${precio},imagen='${nombreImagem}',descripcion='${descripcion}',fechaCurso='${fechaCurso}' where idCursos=${id}";
//       echo $query;

    $resultado = mysqli_query($db, $query);
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
            <input type="text" id="nombre" name="nombre" placeholder="Nombre del curso" value="<?php echo $nombre ?>">

            <label for="capacidad">Capacidad: </label>
            <input type="number" id="capacidad" name="capacidad" placeholder="Capacidad del curso" value="<?php echo $capacidad ?>">

            <label for="precio">Precio: </label>
            <input type="number" id="precio" name="precio" placeholder="Precio del Curso" value="<?php echo $precio ?>">

            <label for="fecha">Fecha del Curso: </label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fechaCurso ?>">

            <label for="imagen">Imagen del Curso: </label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
            <img src="/imagenes/<?php echo $imagenCurso; ?>" class="imagen-small" alt="Imagen de la consulta">

            <label for="descripcion">Descripcion: </label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion ?></textarea>

        </fieldset>
        <fieldset>
            <legend>Verdedor</legend>
            <select name="maestro">
                <option value="">--Seleccione un maestro--</option>
                <?php while($maestros=mysqli_fetch_assoc($resultados)): ?>
                        <option  <?php echo $maestro===$maestros['idMaestro'] ? 'selected' : ''; ?>  value="<?php echo $maestros['idMaestro']; ?> "><?php echo $maestros['nombreM']." ".$maestros['apellido']; ?></option>
                <?php endwhile; ?>
            </select>
        </fieldset>
        <br>
        <input type="submit" value="Crear propiedad" class="boton boton--secundario">
    </form>
</main>
<?php
incluirTemplates('footer');
?>