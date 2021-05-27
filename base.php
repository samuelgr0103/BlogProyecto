<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Pagina web de blog de cafe" />
    <title>Blog cafe</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <!--Prefetch-->
    <link rel="prefetch" href="nosotros.php" as="document" />
    <!--Preload-->

    <link rel="preload" href="build/css/app.css" as="style" />
    <link rel="stylesheet" href="build/css/app.css" />
  </head>
  <body>
    <header class="header">
      <div class="contenedor">
        <div class="barra">

          <a class="logo" href="index.php">

            <h1 class="logo__nombre no-margin centrar-texto">
              Blog <samp class="logo__bold">deCafe</samp>
            </h1>
          </a>
          <nav class="navegacion">
            <a href="nosotros.php" class="navegacion__enlace">Nosotros</a>
            <a href="cursos.php" class="navegacion__enlace">Cursos</a>
            <a href="contacto.php" class="navegacion__enlace">Contacto</a>
            <a href="tienda.php" class="navegacion__enlace">Tienda</a>
          </nav>
          <nav id="existe" class="navegacion ">
            <a href="inicio.php" class="navegacion__enlace">Inicio</a>
            <a href="registrar.php" class="navegacion__enlace">Registrar</a>
          </nav>

        </div>
      </div>

      <div class="header__texto">
        <h2  class="no-margin">Blog de cafe con consejos y cursos</h2>
        <p class="no-margin">
          Aprender de los expertos con las mejores recetas y consejos
        </p>
      </div>
    </header>
    
    <div class="contenedor contenido-principal">
      <main class="blog">
        <h3>Nuestro Blog</h3>

        <article class="entrada">
          <div class="entrada__imagen">
            <picture>
              <source src="build/img/blog1.jpg" type="imagen/webp" />
              <img loading="lazy" src="build/img/blog1.jpg" alt="imagen blog" />
            </picture>
          </div>
          <div class="entrada__contenido">
            <h4 class="no-margin">Tipos de grano de cafe</h4>
            <p>
              Lorem, ipsum dolor sit amet consectetur adipisicing elit. Placeat
              delectus labore et, recusandae aspernatur repudiandae tenetur non
              incidunt, doloribus ut unde harum fuga sed cupiditate cumque
              vitae? Iste, corrupti porro?
            </p>
            <a href="entrada.php" class="boton boton--primario"
              >Leer entrada</a
            >
          </div>
        </article>

        <article class="entrada">
          <div class="entrada__imagen">
            <picture>
              <source src="build/img/blog2.jpg" type="imagen/webp" />
              <img loading="lazy" src="build/img/blog2.jpg" alt="imagen blog" />
            </picture>
          </div>
          <div class="entrada__contenido">
            <h4 class="no-margin">3 Deliciosas Recetas de Cafe</h4>
            <p>
              Lorem, ipsum dolor sit amet consectetur adipisicing elit. Placeat
              delectus labore et, recusandae aspernatur repudiandae tenetur non
              incidunt, doloribus ut unde harum fuga sed cupiditate cumque
              vitae? Iste, corrupti porro?
            </p>
            <a href="entrada.php" class="boton boton--primario"
              >Leer entrada</a
            >
          </div>
        </article>

        <article class="entrada">
          <div class="entrada__imagen">
            <picture>
              <source src="build/img/blog3.jpg" type="imagen/webp" />
              <img loading="lazy" src="build/img/blog3.jpg" alt="imagen blog" />
            </picture>
          </div>
          <div class="entrada__contenido">
            <h4 class="no-margin">Beneficios de cafe</h4>
            <p>
              Lorem, ipsum dolor sit amet consectetur adipisicing elit. Placeat
              delectus labore et, recusandae aspernatur repudiandae tenetur non
              incidunt, doloribus ut unde harum fuga sed cupiditate cumque
              vitae? Iste, corrupti porro?
            </p>
            <a href="entrada.php" class="boton boton--primario"
              >Leer entrada</a
            >
          </div>
        </article>
      </main>
      <aside class="sidebar">
        <h3>Nuestro cursos</h3>
        <ul class="cursos no-padding">
          <li class="widget-curso">
            <h4 class="no-margin">Tecnicas de Extracion de cafe</h4>
            <p class="widget-curso__label">
              Precio:
              <span class="widget-curso__info">Gratis</span>
            </p>
            <p class="widget-curso__label">
              Cupo:
              <span class="widget-curso__info">20</span>
            </p>
            <a href="entrada.php" class="boton boton--secundario"
              >Mas Informacion</a
            >
          </li>

          <li class="widget-curso">
            <h4 class="no-margin">4 Recetas de Cafe para Principiantes</h4>
            <p class="widget-curso__label">
              Precio:
              <span class="widget-curso__info">Gratis</span>
            </p>
            <p class="widget-curso__label">
              Cupo:
              <span class="widget-curso__info">20</span>
            </p>
            <a href="entrada.php" class="boton boton--secundario"
              >Mas Informacion</a
            >
          </li>
        </ul>
      </aside>
    </div>
    <footer class="footer">
      <div class="contenedor">
        <div class="barra">
          <a class="logo" href="index.php">
            <h1 class="logo__nombre no-margin centrar-texto">
              Blog <samp class="logo__bold">deCafe</samp>
            </h1>
          </a>
          <nav class="navegacion">
            <a href="nosotros.php" class="navegacion__enlace">Nosotros</a>
            <a href="cursos.php" class="navegacion__enlace">Cursos</a>
            <a href="contacto.php" class="navegacion__enlace">Contacto</a>
          </nav>
        </div>
      </div>
    </footer>

    <script src="js/modernizr.js"></script>
    
  </body>
</html>
