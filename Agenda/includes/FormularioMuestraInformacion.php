



<?php 

require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';

class FormularioMuestraInformacion extends Form{

	

	public function __construct(){
		parent::__construct('formMuestraContacto');
	}


	protected function generaCamposFormulario($datosIniciales, $errores = array()){
			
       
        $telefono = $datos['telefono'] ?? '';

        
        
        $erroresGlobales = self::generaListaErroresGlobales($errores);
        
        $errorTelefono = self::createMensajeError($errores, 'telefono', 'span', array('class' => 'error'));~

        $formulario = <<<EOF
        <fieldset>
            $erroresGlobales
            
            <div class="grupo-control">
                <p> Numero de Telefono que quieres ver la informacion de tu agenda: </p> <input class="control" type="text" name="telefono" />
                <p>$errorTelefono</p>
            </div>
            <div class="grupo-control"><button type="submit" name="verinformacion">Ver informacion del Contacto</button></div>
            </fieldset>
    EOF;

    return $formulario;
}


protected function procesaFormulario($datos){

    $contac = Usuario::buscarContacto($_SESSION['email_usuario'],$datos['telefono']);

    if($contac!=false){

       Usuario::muestrainformacionContacto($contac[1],$contac[2],$contac[3]);

    }
    else{
        echo "No tienes ese contacto en la agenda";
    }

}
}

?>