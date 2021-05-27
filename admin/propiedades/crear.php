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

//Consultar para obtener los vendedores
$consulta="SELECT *FROM maestro";
$resultados=mysqli_query($db,$consulta);


//Arreglo con mensajes de errores
$errores = [];

$nombre = '';
$capacidad = '';
$precio = '';
$descripcion = '';
$maestro = '';
$fechaCurso='';

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
    if(!$imagen['name']){
        $errores[]='La imagen es obligatoria';
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
        //generando nombre aleatorio
        $nombreImagem=md5(uniqid(rand(),true)).'.jpg';

        move_uploaded_file($imagen['tmp_name'],$carpetaImagenes.$nombreImagem);

        //Ingresar a la base de datos
        $query = "INSERT INTO cursos (nombre,Capacidad,precio,imagen,descripcion,fechaCurso,idMaestro) VALUES ('$nombre','$capacidad','$precio','$nombreImagem','$descripcion','$fechaCurso','$maestro')";
        //echo $query;

        $resultado = mysqli_query($db, $query);
        if ($resultado) {
        
            //Redireccionar al usuario
            header('Location: /admin?resultado=1');
        }
        
    }
}

incluirTemplates('header');
?>

<main class="contenedor">
    <h3 class="centrar-texto">Crear</h3>
    <a href="/admin" class="boton boton--primario">Volver</a>
    <br>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error"><?php echo $error; ?></div>
    <?php endforeach ?>
    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
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