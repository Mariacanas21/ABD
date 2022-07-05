
<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';

class FormularioBorrarContacto extends Form{

	public function __construct(){
		parent::__construct('formBorrarcontacto');
	}

	protected function generaCamposFormulario($datosIniciales, $errores = array()){
			
       
        $telefono = $datos['telefono'] ?? '';

        
        
        $erroresGlobales = self::generaListaErroresGlobales($errores);
        
        $errorTelefono = self::createMensajeError($errores, 'telefono', 'span', array('class' => 'error'));~

        $formulario = <<<EOF
        <fieldset>
            $erroresGlobales
            
            <div class="grupo-control">
                <p> Numero de Telefono que quieres eliminar de tu agenda: </p> <input class="control" type="text" name="telefono" />
                <p>$errorTelefono</p>
            </div>
            <div class="grupo-control"><button type="submit" name="eliminarContacto">Eliminar Contacto</button></div>
            </fieldset>
    EOF;

    return $formulario;
}

protected function procesaFormulario($datos){

    
     Usuario::eliminarContacto($_SESSION['email_usuario'],$datos['telefono']);
    
    
}

}
?>