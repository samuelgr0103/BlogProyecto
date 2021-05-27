<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="build/css/app.css">

</head>
<body>
    
  
    <div class="contenedor-estetica">
        <div class="imagen-tienda">
            <a class="logo barra contenedor" href="index.php">
                <h1 class="logo__nombre no-margin centrar-texto">
                  Blog <samp class="logo__bold">deCafe</samp>
                </h1>
              </a>
        
        </div>

        <div class="app">
            <header class="header-tienda">
                <h1>Tienda</h1>
            </header>
            <nav class="tabs">
                <button type="button" data-paso="1">Productos</button>
                <button type="button" data-paso="2">Información Cliente</button>
                <button type="button" data-paso="3">Compra</button>
            </nav>
            <!--Inicia cotenido App-->
            <div id="paso-1" class="seccion">
                <h2>Servicios</h2>
                <p class="text-center">Elige tus servicios a Continuacion</p>
                <div id="servicios" class="listado-servicios">

                </div>
            </div>
            <div id="paso-2" class="seccion">
                <h2>Datos y Cita</h2>
                <p class="text-center">
                    Coloca tus datos y fecha de tu cita
                </p>
                <form class="formulario-tienda">
                    <div class="campo">
                        <label for="nombre" >Nombre</label>
                        <input id="nombre" type="text" placeholder="Tu nombre">
                    </div>
                    <div class="campo">
                        <label for="fecha" >Fecha</label>
                        <input id="fecha" type="date">
                    </div>
                    <div class="campo">
                        <label for="hora" >Hora</label>
                        <input id="hora" type="time">
                    </div>

                </form>

            </div>
            <div id="paso-3" class="seccion contenido-resumen">
                <h2>Resumen</h2>
            </div>
            <div class="paginacion">
                <button id="anterior">
                   &laquo; Anterior
                </button>
                <button id="siguiente">
                    Siguiente &raquo;
                </button>
            </div>
        </div>
    </div>
<script src="js/tienda.js"></script>
    
</body>

</html>