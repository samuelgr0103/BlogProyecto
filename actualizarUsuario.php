<?php
//Importar la conexion
require 'include/config/database.php';
$db=conectarDB();
$errores=[];
$id=$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email=filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
  $validarEmail=filter_var($_POST['validaEmail'],FILTER_VALIDATE_EMAIL);


  if(!$email){
    $errores[]="El Email es obligatorio ó no es valido";
  }
  if(!$validarEmail){
    $errores[]="Ingresa de nuevo tu Email";
  }
    
      if(empty($errores)){

        //Ahora verificamos si existe
        $recuperar="UPDATE usuarios set email='${email}' where idusuarios=${id}";
        var_dump($recuperar);
        $validarUsuario=mysqli_query($db,$recuperar);
        header('location: /inicio.php');
        }else{
            $errores[]="El Usuario no existe";
        }
    


      }


?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Blog Inicio</title>
    <link rel="preload" href="build/css/app.css" as="style" />
    <link rel="stylesheet" href="build/css/app.css" />
    <script src="https://www.gstatic.com/firebasejs/8.4.1/firebase.js"></script>

    
  </head>
  <body class="ody">
    <header class="header">
        <div class="contenedor">
          <div class="barra">
  
            <a class="logo" href="index.php">
  
              <h1 class="logo__nombre no-margin centrar-texto">
                Blog <samp class="logo__bold">deCafe</samp>
              </h1>
            </a>
  
          </div>
        </div>
     </header>
      

    <div class="login-box">
      <img src="build/img/cafe.jpg" class="avatar" alt="Avatar Image">
      <h1>Recuperar</h1>
      <?php foreach($errores as $error): ?>
        <div class="alerta error"><?php echo $error; ?></div>
      <?php endforeach;  ?>

      <form id="inicio" method="POST">
        <!-- USERNAME INPUT -->
        <label for="email">Nuevo Correo</label>
        <input id="email" type="email" name="email" placeholder="Ingresa tu Correo">
        <label for="validaEmail">Confirma Correo</label>
        <input id="validaEmail" type="email" name="validaEmail" placeholder="Vuelve a ingresar tu correo">

        <!-- PASSWORD INPUT -->
        <input type="submit" value="Actualizar">

      </form>
  </div>

  </body>

</html>
