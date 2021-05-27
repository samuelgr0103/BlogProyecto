<?php 
require 'include/funciones.php';
incluirTemplates('header',$inicio=true);
?>
   
<div class="contenedor contenido-principal">
      <main class="blog">
        <h3>Nuestro Blog</h3>

        <?php 
          $limite=3;
          include 'include/templates/cursos.php';
        ?>
        
      </main>
<?php 
  $db = conectarDB();
  //Consultar

  $consulta="SELECT *from maestro,cursos where cursos.idMaestro=maestro.idMaestro ORDER BY cursos.idCursos DESC limit ${limite}";
  $resultadosConsulta=mysqli_query($db,$consulta);

?>

      <aside class="sidebar">
        <h3>Nuestro cursos</h3>
        <ul class="cursos no-padding">
        <?php while ($curso = mysqli_fetch_assoc($resultadosConsulta)) : ?>
          <li class="widget-curso">
            <h4 class="no-margin"><?php echo $curso['nombre']; ?></h4>
            <p class="widget-curso__label">
              Precio:
              <span class="widget-curso__info"><?php echo $curso['precio']; ?></span>
            </p>
            <p class="widget-curso__label">
              Cupo:
              <span class="widget-curso__info"><?php echo $curso['Capacidad']; ?></span>
            </p>
            <a href="entrada.php?id=<?php echo $curso['idCursos']; ?>" class="boton boton--secundario"
              >Mas Informacion</a
            >
          </li>
          <?php endwhile; ?>

    
        </ul>
      </aside>
    </div>
<?php 
mysqli_close($db);
incluirTemplates('footer');
?>
   