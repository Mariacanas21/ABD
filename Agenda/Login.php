

<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioLogin.php';


?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
  	<title>Login</title>
</head>
<body>
<div id="contenedor">
	<?php
		require("includes/comun/cabecera.php");
		require("includes/comun/sidebarIzq.php");
		
	?>
	
	<div id="contenido" class="contenido">
			<?php 
			
			$formLogin = new FormularioLogin(); 
			$formLogin->gestiona();
			?>
		</div>
	<?php
		
		require("includes/comun/pie.php");
	?>
</div>
</body>
</html>