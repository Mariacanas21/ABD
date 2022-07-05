


<?php
require_once __DIR__.'/includes/config.php';
	function mostrarContenido(){
	?>	
	<div id="contenido" class="contenido">
    <h1> Bienvenido a E-Contact </h1>

    <p>La función de E-Contact será una agenda de contactos online, siendo
    una forma ideal de mantener una visión general de tu comunicación. 
    Organice, gestione y visualice la información de sus contactos, asi como
    el historial de llamadas.</p>
    
    <p> Dentro de tu agenda podrás añadir, borrar, consultar la información de 
    los contactos que tengas en tu agenda de una forma facil y sencilla gracias a 
    nuestra interfaz </p>
    
    <div>
        <h3> Una práctica agenda de contactos </h3>
    
    </div>
    
    <div>
        <h3> Encuentra facilmente a tus contactos gracias al filtro de búsqueda </h3>
    </div>

	</div>
    <?php
	}



		
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	
  	<title>E-contact</title>
</head>
<body>
<div id="contenedor" class="contenedor">
	<?php
		
		require("includes/comun/cabecera.php");
		require("includes/comun/sidebarIzq.php");
	?>
	
		<div id="contenido" class="contenido">
				<?= mostrarContenido() ?>
		</div>
	<?php
		
		require("includes/comun/pie.php");
	?>
</div>
</body>
</html>

