

<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioRegistro.php';
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css" />
  	<title>Registro</title>
</head>
<body>
<div id="contenedor">
	<?php
		require("includes/comun/cabecera.php");
		require("includes/comun/sidebarIzq.php");
		
	?>
	
		<div id="contenido" class="contenido">
			<?php 
			if(!isset($_SESSION["login"])){
			$formRegister = new FormularioRegistro(); 
			$formRegister->gestiona();
			}
			else{
				?>
				<h3>Ya tienes iniciada la sesión</h3>
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