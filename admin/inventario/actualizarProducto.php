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

//Conectar a la base
require '../../include/config/database.php';
$db = conectarDB();
$id=$_GET['id'];
$id=filter_var($id,FILTER_VALIDATE_INT);
if(!$id){
header('Location: /admin/inventario/mostrarInventario.php');
}

$consulta="SELECT *FROM inventario where idinventario=${id}";
$resultadoConsulta=mysqli_query($db,$consulta);
$cursos=mysqli_fetch_assoc($resultadoConsulta);
//var_dump($cursos);


//Arreglo con mensajes de errores
$errores = [];

$nombre = $cursos['nombreProducto'];
$stock = $cursos['stockInicio'];
$precio = $cursos['precioInicio'];
$descripcion = $cursos['descripcionProducto'];
$imagenInventario = $cursos['imagen'];

//Ejecutar el codigo despues de que el usuario envia el formulario
//var_dump($_SERVER);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
 //      echo "<pre>";
 //      var_dump($_POST);
 //    echo "</pre>";

    //exit;

    $nombre = mysqli_real_escape_string($db, $_POST['nombre']);
    $stock = mysqli_real_escape_string($db, $_POST['stock']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    //Asignar file hacia una variables
    $imagen = $_FILES['imagen'];


    if (!$nombre) {
        $errores[] = "Debes añadir el nombre del Producto";
    }
    if (!$stock) {
        $errores[] = "Debes añadir cuantos productos ingresaron";
    }
    if (!$precio) {
        $errores[] = "Debes añadir el precio del Producto";
    }
    if (strlen($descripcion) < 20) {
        $errores[] = "La descripcion es obligatoria y debe tener mas de 20 caracteres";
    }
    //Validar tamano
    $medida = 1000 * 1000;
    if ($imagen['size'] > $medida) {
        $errores[] = 'La imagen es muy pesada';
    }



//    echo "<pre>";
//    var_dump($errores);
//    echo "</pre>";
    //Resivsar que el arreglo de errores esta vacio
    if (empty($errores)) {

        //*Sibida de archivos */

        //Crear carpeta
        $carpetaImagenes = '../../imagenes/';

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

       if($imagen['name']){
          unlink($carpetaImagenes.$cursos['imagen']);
        //generando nombre aleatorio
        $nombreImagem=md5(uniqid(rand(),true)).'.jpg';

        move_uploaded_file($imagen['tmp_name'],$carpetaImagenes.$nombreImagem);

        }else{
          $nombreImagem=$cursos['imagen'];
        }
         //Ingresar a la base de datos
        $query = "UPDATE inventario set nombreProducto='${nombre}',imagen='${nombreImagem}',precioInicio='${precio}',stockInicio='${stock}',descripcionProducto='${descripcion}' where idinventario=${id}";
       //  var_dump($query);
       //  exit;   
        $resultado = mysqli_query($db, $query);
        if ($resultado) {

            //Redireccionar al usuario
            header('Location: /admin/inventario/mostrarInventario.php?resultado=2');
        }
    }
}

incluirTemplates('header');
?>

<main class="contenedor">
    <h3 class="centrar-texto">Actualizar Producto</h3>
    <a href="/admin/inventario/mostrarInventario.php" class="boton boton--primario">Volver</a>
    <br>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error"><?php echo $error; ?></div>
    <?php endforeach ?>
    <form class="formulario" method="POST"  enctype="multipart/form-data">
        <fieldset>
            <legend>Ingresar Curso</legend>
            <label for="nombre">Nombre del Producto: </label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre del curso" value="<?php echo $nombre ?>">
            <label for="imagen">Imagen del Curso: </label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
            <img src="/imagenes/<?php echo $imagenInventario; ?>" class="imagen-small" alt="Imagen de la consulta">

            <label for="precio">Precio del Producto: </label>
            <input type="number" id="precio" name="precio" placeholder="Precio del producto" value="<?php echo $precio ?>">

            <label for="stock">Stock inicio: </label>
            <input type="number" id="stock" name="stock" placeholder="Stock en el inventario" value="<?php echo $stock ?>">


            <label for="descripcion">Descripcion: </label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion ?></textarea>

        </fieldset>
        <br>
        <input type="submit" value="Actualizar Producto" class="boton boton--secundario">
    </form>
</main>
<?php
incluirTemplates('footer');
?>