<?php
//Importar la conexion
require 'include/config/database.php';
$db=conectarDB();
$errores=[];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email=filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
  $password=$_POST['password'];

  $passwordHash=password_hash($password,PASSWORD_BCRYPT);

  if(!$password){
    $errores[]="El passwors es obligatorio no es valido";
  }
  if(!$email){
    $errores[]="El Email es obligatorio no es valido";
  }
      if(empty($errores)){
        //Revisar si existe el usuario
        $query="SELECT *FROM usuarios where email='${email}'";
        $consulta=mysqli_query($db,$query);

        if($consulta->num_rows){
            $usuarios=mysqli_fetch_assoc($consulta);
            //verificar si el password
            $auth=password_verify($password,$usuarios['password']);

            if($auth){
              //El usuario es autenticado
              session_start();
              $_SESSION['usuario']=$usuarios['email'];
              $_SESSION['login']=true;
              $_SESSION['idcliente']=$usuarios['idcliente'];;
              header('location: /');
              
            }else{
              $errores[]="EL password es incorrecto";
            }

        }else{
          $errores[]="El Usuario no existe";
        }

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
      <h1>Inicio</h1>
      <?php foreach($errores as $error): ?>
        <div class="alerta error"><?php echo $error; ?></div>
      <?php endforeach;  ?>

      <form id="inicio" method="POST">
        <!-- USERNAME INPUT -->
        <label for="email">Correo</label>
        <input id="email" type="email" name="email" placeholder="Ingresa tu Correo">
        <!-- PASSWORD INPUT -->
        <label for="password">Contraseña</label>
        <input id="password" type="password" name="password" placeholder="Ingresa Contraseña" >
        <input type="submit" value="Acceder">
        <a href="#">Olvidaste tu contraseña?</a><br>
        <a href="/recuperarUsuario.php">Olvidaste tu Usuario?</a>
      </form>
      <div id="secion">
    </div>
  </div>

  </body>

</html>
