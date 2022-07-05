<?php
function mostrarSaludo() {
	
	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		echo "Bienvenid@, " . $_SESSION['nombre'] . ".<a href='logout.php'> (Cerrar Sesión) </a> <a href='editarDatosUsuario.php'>Editar mis datos de usuario</a></h3>";
		
	} else {
		echo " Usuario desconocido. <a href='login.php'> Login </a> <a href='registro.php'>  Registro </a>";
	}
}
?>
<header>
	<img id="imagenlogo" src="imagenes/logo1.png">
	
	<div class="saludo">
	<?php
		mostrarSaludo();
	?>
	</div>
</header>