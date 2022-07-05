
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<footer class="pie">
<?php
if (!isset($_SESSION["login"])) {
  ?>
	<div>
	<p> ¿Todavía no tienes una agenda de contactos en E-CONTACT?</p>
	<p><a class="creacuenta" href="Registro.php"> Crear Cuenta </a></p>
	</div>
  <?php
} ?>

	<section id="red" class="red">
		<p> Página creada por María Cañas </p>
        <h3> Mis Redes sociales </h3>
        <div id="redes-sociales" class="redes-sociales">
        <span class="material-icons"> integration_instructions
</span>
        <a href="https://github.com/" target="_blank" id="profile-link"> GitHub </a>
          
          
         <span class="material-icons">
account_circle
</span>
          <a href="https://www.instagram.com/" target="_blank" id="profile-link"> Instagram </a>
          
        </div>
      </section>

</footer>