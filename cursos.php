<?php

require 'include/funciones.php';
incluirTemplates('header');


?>


<main class="contenedor">
  <h3 class="centrar-texto">Nuestro proximos Cursos</h3>
  <?php
  require 'include/config/database.php';
  $db = conectarDB();
  //Consultar

  $consulta="SELECT *FROM maestro";
  $resultadosConsulta=mysqli_query($db,$consulta);
  

  $limite = 10;

  $query = " SELECT *from maestro,cursos where cursos.idMaestro=maestro.idMaestro limit ${limite} ";
  //Obteniendo resultado
  $resultado = mysqli_query($db, $query);
  ?>
<?php while ($curso = mysqli_fetch_assoc($resultado)) : ?>

  <div class="curso">
    <div class="curos__imagen">
    <img loading="lazy" src="/imagenes/<?php echo $curso['imagen']; ?>" alt="imagen del curso" />
    </div>

    <div class="curso__informacion">
      <h4 class="no-margin"><?php echo $curso['nombre']; ?></h4>
      <p class="curso__label">
        Precio:
        <span class="curso__info"><?php echo $curso['precio']; ?></span>
      </p>
      <p class="curso__label">
        Cupo:
        <span class="curso__info"><?php echo $curso['Capacidad']; ?></span>
      </p>
      <p class="curso__label">
        Fecha del curso:
        <span class="curso__info"><?php echo $curso['fechaCurso']; ?></span>
      </p>
      <p class="curso__label">
        Maestro Asignado:
        <span class="curso__info"><?php echo $curso['nombreM']." ".$curso['apellido'];; ?></span>
      </p>


      <p class="curso__descripcion"><?php echo $curso['descripcion']; ?></p>

    </div>
    <a href="entrada.php?id=<?php echo $curso['idCursos']; ?>" class="boton boton--primario">Leer entrada</a>
    <!--Este cierra el curso infromacion-->
  </div>

  <!--Este cierra el curso-->
  <?php endwhile; ?>




</main>
<?php

//Cerrar la conexion
mysqli_close($db);
incluirTemplates('footer');
?>