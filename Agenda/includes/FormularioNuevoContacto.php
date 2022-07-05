


<?php 

require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';


class FormularioNuevoContacto extends Form{

	public function __construct(){
		parent::__construct('formNuevoContacto');
	}

	
	protected function generaCamposFormulario($datosIniciales, $errores = array()){
        $nombre = $datos['nombre'] ?? '';

        $apellido = $datos['apellido'] ?? '';
        $telefono = $datos['telefono'] ?? '';
        $image = $datos['image'] ?? '';

        $erroresGlobales = self::generaListaErroresGlobales($errores);
        
        $errorNombre = self::createMensajeError($errores, 'nombre', 'span', array('class' => 'error'));
        $errorApellido = self::createMensajeError($errores, 'apellido', 'span', array('class' => 'error'));
        $errorTelefono = self::createMensajeError($errores, 'telefono', 'span', array('class' => 'error'));~

        $formulario = <<<EOF
        <fieldset>
            $erroresGlobales
            <div class="grupo-control">
                <label> Nombre : </label> <input class="control" type="text" placeholder="" name="nombre" value="$nombre"/>
                <p>$errorNombre</p>
            </div>
            <div class="grupo-control">
                <label> Apellido : </label> <input class="control" type="text" name="apellido" value="$apellido"/>
                <p>$errorApellido</p>
            </div>
            <div class="grupo-control">
                <label> Telefono : </label> <input class="control" type="text" name="telefono" value="$telefono" />
                <p>$errorTelefono</p>
            </div>

           
            
            <div class="grupo-control"><button type="submit" name="editarContacto"> Añadir contacto </button></div>
            </fieldset>
    EOF;

    
    return $formulario;
}

	protected function procesaFormulario($datos){
		$resultado = array();
		
       
		$nombre = $datos['nombre'] ?? null;
		if ( empty($nombre) ) {
			$resultado['nombre'] = "El campo de nombre no puede estar vacio";
		}

		$apellido = $datos['apellido'] ?? null;
		if(empty($apellido)){
			$resultado['apellido'] = "El campo de apellido no puede estar vacio";
		}

		$telefono = $datos['telefono'] ?? null;
		if ( empty($telefono)|| mb_strlen($telefono) != 9) {
			$resultado['telefono'] = " El campo del telefono tiene que tener 9 números";
		}

       
      
		if (count($resultado) === 0) {
		/* Añadir los datos */
           
        $re = Usuario::insertaContacto($nombre, $apellido,$telefono,$_SESSION['email_usuario']);

		}
		return $resultado;
	}

   
}


?>