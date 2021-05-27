<?php 

$id=$_GET['id'];
$id=filter_var($id,FILTER_VALIDATE_INT);
//var_dump($id);
  if(!$id){
    header('location: /');
  }

require 'include/funciones.php';
incluirTemplates('header');
?>
   
<main class="contenedor">
    <?php
  require 'include/config/database.php';
  $db = conectarDB();

  $query = "SELECT * from cursos where idCursos=${id} ";
  //Obteniendo resultado
  $resultado = mysqli_query($db, $query);
  $curso = mysqli_fetch_assoc($resultado);

  if($resultado->num_rows===0){
    header('location: /');

  }

  ?>

      <h3 class="centrar-texto"><?php echo $curso['nombre']; ?></h3>
      <img src="/imagenes/<?php echo $curso['imagen']; ?>" alt="imagen del blog" />
      <div class="entrada__contenido">
            <h4 class="no-margin"><?php echo $curso['nombre']; ?></h4>
            <p><?php echo $curso['descripcion']; ?> </p>
               
            <ul class="iconos-caracteristicas">
            <li>
            <p><span> Capacidad:</span> <?php echo $curso['Capacidad']; ?></p>
            </li>
            <li>
            <p><span> Precio: </span><?php echo $curso['precio']; ?></p>
            </li>
            <li>
            <p><span> Fecha del curso: </span><?php echo $curso['fechaCurso']; ?></p>
            </li>

        </ul>
            <a href="entrada.php?id=<?php echo $curso['idCursos']; ?>" class="boton boton--primario">Inscribirte</a>

        </div>

      <p class="just">
        In cursus nibh quis turpis maximus facilisis. Curabitur nisi enim,
        pulvinar sit amet mi ut, consectetur porta tellus. Ut placerat elementum
        ante, tincidunt accumsan eros congue et. Integer sed lacinia ligula.
        Vestibulum congue quam vel nulla fermentum, quis mollis risus feugiat.
        Vivamus nec malesuada velit, in faucibus eros. Nulla sit amet pharetra
        neque, quis rhoncus tortor. Vivamus et sodales leo. Cras commodo iaculis
        feugiat. Quisque euismod tellus quam, vitae vestibulum dolor porttitor
        sit amet.
      </p>

      <p class="just">
        Donec velit nulla, ullamcorper id auctor quis, sollicitudin nec augue.
        Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere
        cubilia curae; Donec suscipit et dolor a vestibulum. Nunc sed nisi
        pretium, malesuada odio sed, gravida felis. Nulla vel nibh sem. Donec
        rhoncus quam vitae nibh malesuada congue. Quisque et felis in odio
        rutrum elementum. Pellentesque tincidunt augue auctor nulla ultricies,
        sed cursus felis consequat. Praesent ac vestibulum ex. Nunc vel
        consectetur libero. Duis in ante scelerisque, imperdiet leo at, posuere
        nisl. Sed id mi ultrices, aliquet est quis, condimentum ipsum.
      </p>

      <p class="just">
        In purus leo, tincidunt non rutrum ac, suscipit et velit. Ut placerat
        massa quis massa porta varius. Sed neque enim, pharetra vitae lacinia
        ut, tempor mattis ante. Sed id fringilla mauris. Maecenas semper tellus
        eros, ut sodales dui vulputate rhoncus. Orci varius natoque penatibus et
        magnis dis parturient montes, nascetur ridiculus mus. Aenean venenatis
        nibh tortor, sit amet fringilla nibh efficitur nec. Quisque cursus
        feugiat orci. Duis in hendrerit velit.
      </p>


    </main>
    <?php 
    mysqli_close($db);
incluirTemplates('footer');
?>
