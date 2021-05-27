<?php 
require 'include/funciones.php';
incluirTemplates('header');
?>
   
    <main class="contenedor">
      <h3 class="centrar-texto">Contacto</h3>

      <div class="contacto-bg"></div>

      <form class="formulario">
        <div class="campo">
          <label class="campo__label" for="nombre">Nombre</label>
          <input
            class="campo__field"
            type="text"
            placeholder="Tu nombre"
            id="nombre"
          />
        </div>
        <div class="campo">
          <label class="campo__label" for="email">E-mail</label>
          <input
            class="campo__field"
            type="email"
            placeholder="Tu-Email"
            id="email"
          />
        </div>
        <div class="campo">
          <label class="campo__label" for="mensaje">Mensaje</label>
          <textarea
            class="campo__field campo__field__textarea"
            id="mensaje"
            cols="30"
            rows="10"
          ></textarea>
        </div>
        <div class="campo">
          <input id="btn" type="submit" value="Enviar" class="boton boton--primario" />
        </div>
      </form>
    </main>
    <script src="js/Scripts.js"></script>
    <?php 
incluirTemplates('footer');
?>