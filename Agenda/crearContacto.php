

<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioNuevoContacto.php';

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css" />
  	<title>Crear Contacto</title>
</head>
<body>
<div id="contenedor">
	<?php
		require("includes/comun/cabecera.php");
		require("includes/comun/sidebarIzq.php");
		
	?>
	
		<div id="contenido" class="contenido">
			<?php 
			if(isset($_SESSION["login"])){
			$formNuContacto = new FormularioNuevoContacto(); 
			$formNuContacto->gestiona();
			}
			else{
				?>
				<h3>Debes iniciar sesion</h3>
				<?php
			}
			?>
		</div>
	<?php
		
		require("includes/comun/pie.php");
	?>
</div>
</body>
</html>