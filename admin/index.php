<?php 
require '../include/funciones.php';
$auth=estaAutenticado();
$usuario=$_SESSION['usuario'];
if(!$auth ){
    header('location: /');
}
if($usuario!=='samuelgr62@gmail.com'){
    header('location: /');
}

$resultado=$_GET['resultado']?? null;
incluirTemplates('header');
?>
   
    <main class="contenedor">
      <h1 class="centrar-texto">Administrador del blog</h1>
           <?php if(intval($resultado)===1): ?>
              <p class="alerta exito">Curso Creado Correctamente</p>
              <?php elseif(intval($resultado)===2): ?>
              <p class="alerta exito">Curso Actualizado Correctamente</p>
              <?php elseif(intval($resultado)===3): ?>
              <p class="alerta exito">Curso Eliminado Correctamente</p>
    
           <?php endif; ?>
          
        <a href="/admin//propiedades/crear.php" class="boton boton--primario">Nuevo curso</a>
        <a href="/admin//propiedades/mostrar.php" class="boton boton--primario">Mostrar Cursos</a>
        <a href="/admin/usuarios/mostrarUsuarios.php" class="boton boton--primario">Mostrar usuarios</a>
        <a href="/admin/inventario/mostrarInventario.php" class="boton boton--primario">Mostrar inventario</a>
        <a href="/admin/ventas/mostrarVentas.php" class="boton boton--primario">Mostrar Ventas</a>

        
    </main>
    <?php 
incluirTemplates('footer');
?>