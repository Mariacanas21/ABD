
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<?php

	function mostrarContactos(){
		$app = Aplicacion::getInstancia();
		$conn = $app->conexionBd();
		$con = null;
		if(isset($_SESSION["login"])){
		
		
		$contacto = contacto::buscarContactosUsuario($app->email_usuario());
	

		if($contacto){
			?>
			<div id="historialC" class="historialC"> <?php
			$con .= "<table>";
				
			$con .= "<tr>";
			$con .= "<th> Nombre </th>";
			$con .= "<th> Apellido </th>";
			$con .= "<th> Telefono </th>";
			$con .= "</tr>";

			foreach($contacto as $info => $contac){
				$con .= "<tr>";
				$con .= "<td>" .$contac['nombre'] . ' ' ."</td>";
				$con .= "<td>" .$contac['apellido'] . ' ' ."</td>";
				$con .= "<td>" .$contac['telefono'] . ' ' ."</td>";
				$con .= "<td>" ."<span class='material-icons'> account_circle </span>" . ' ' ."</td>";
				$con .= "</tr>";
				$nom = $contac['nombre'];
				$con .= '<br>';
			}
			$con .= "</table>";
			?>
			</div> <?php
		
		}
	}
	else{
		?>
		<h3>Debes iniciar sesion</h3>
		<?php
	}
		return $con;
	}
require_once __DIR__.'/includes/config.php';

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
  	<title>Contactos</title>
</head>
<body>
<div id="contenedor" class="contenedor">
	<?php
		require("includes/comun/cabecera.php");
		require("includes/comun/sidebarIzq.php");
		
	?>
	
		<div id="contenido" class="contenido">
				<?= mostrarContactos() ?>
		</div>
	<?php
		
		require("includes/comun/pie.php");
	?>
</div>
</body>
</html>