<?php
//Importar la conexion
require 'include/config/database.php';
$db = conectarDB();
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = filter_var($_POST['nombre']);
  $apellido = filter_var($_POST['apellido']);
  $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
  $password = $_POST['password'];

  $passwordHash = password_hash($password, PASSWORD_BCRYPT);

  if (!$password) {
    $errores[] = "El passwors es obligatorio o no es valido";
  }
  if (!$email) {
    $errores[] = "El Email es obligatorio o no es valido";
  }
  if (!$nombre) {
    $errores[] = "El Nombre es obligatorio o no es valido";
  }
  if (!$apellido) {
    $errores[] = "El Apellido es obligatorio o no es valido";
  }


  if (empty($errores)) {
    //Revisar si existe el usuario
    $query = "SELECT *FROM usuarios where email='${email}'";
    $consulta = mysqli_query($db, $query);
    //      var_dump($query);
    //        var_dump($consulta);

    if (!$consulta->num_rows) {

      $query = "INSERT INTO clientes(nombre,apellido) values('${nombre}','${apellido}')";
        mysqli_query($db, $query);

      $query = "select idcliente from clientes where nombre='${nombre}' and apellido='${apellido}';";
      $resultado = mysqli_query($db, $query);
      $resultadoConsulta = mysqli_fetch_assoc($resultado);
      $id=$resultadoConsulta['idcliente'];

      $query = "INSERT INTO usuarios(email,password,idcliente) values('${email}','${passwordHash}','${id}')";
      mysqli_query($db, $query);
    } else {
      $errores[] = "El Usuario existe";
    }
  }
}

?>


<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Blog Registrar</title>
  <link rel="preload" href="build/css/app.css" as="style" />
  <link rel="stylesheet" href="build/css/app.css" />


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
    <h1>Registrar</h1>
    <?php foreach ($errores as $error) : ?>
      <div class="alerta error"><?php echo $error; ?></div>
    <?php endforeach;  ?>
    <form id="Registrar" method="POST">
      <label for="nombre">Nombre</label>
      <input id="nombre" type="text" name="nombre" placeholder="Ingresa tu Nombre">
      <label for="apellido">Apellido</label>
      <input id="apellido" type="text" name="apellido" placeholder="Ingresa tu Apellido">
      <!-- USERNAME INPUT -->
      <label for="email">Correo</label>
      <input id="email" type="email" name="email" placeholder="Ingresa tu Correo">
      <!-- PASSWORD INPUT -->
      <label for="password">Contraseña</label>
      <input id="password" type="password" name="password" placeholder="Ingresa Contraseña">
      <input type="submit" value="Registrar" />
    </form>
  </div>

</body>

</html>