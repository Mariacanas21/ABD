


<?php 

require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';


class FormularioEditarDatos extends Form{

	public function __construct(){
		parent::__construct('formEditarDatos');
	}

	
	protected function generaCamposFormulario($datosIniciales, $errores = array()){
       
        $nombre = $datos['nombre'] ?? '';
        $apellido = $datos['apellido'] ?? '';
        $erroresGlobales = self::generaListaErroresGlobales($errores);
        
        $errorNombre = self::createMensajeError($errores, 'nombre', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'password1', 'span', array('class' => 'error'));
        
        $formulario = <<<EOF
        <fieldset>
            $erroresGlobales
           
            <div class="grupo-control">
                <label> Nombre : </label> <input class="control" type="text" name="nombre" value="$nombre" placeholder = "$_SESSION[nombre]"/>
                <p>$errorNombre</p>
            </div>
            <div class="grupo-control">
                <label> Apellido : </label> <input class="control" type="text" name="apellido" value="$apellido" placeholder = "$_SESSION[apellido]"/>
                <p>$errorNombre</p>
            </div>
            <div class="grupo-control">
                <label> Contraseña (Antigua): </label> <input class="control" type="password" name="password"/>
                <p>$errorPassword</p>
            </div>

            <div class="grupo-control">
                <label> Contraseña (Nueva): </label> <input class="control" type="password" name="password1"/>
                <p>$errorPassword</p>
            </div>

            <div class="grupo-control"><button type="submit" name="registro">Editar Datos</button></div>
            </fieldset>
    EOF;

    return $formulario;
}


public function procesaFormulario($datos){
   $resultado = array();
   
   
    $nombre = $datos['nombre'] ?? null;
    if ( empty($nombre) ) {
        $nombre = $_SESSION['nombre'];
    }

    $apellido = $datos['apellido'] ?? null;
    if(empty($apellido)){
        $apellido = $_SESSION['apellido'];
    }

    $password = $datos['password'] ?? null;
    if (empty($password)) {
        $password = $_SESSION['contrasenia'];

    }
    else{
        $password1 = $datos['password1'] ?? null;
        if ( empty($password1)) {
            $password = $_SESSION['contrasenia'];
        }
        else{
            if($password == $_SESSION['contrasenia']){
                $password=$password1;
            }
            else{
                echo "Error, la contraseña antigua no coincide con la introducida";
                return false;
            }
        }
    }
    return Usuario::actualiza($_SESSION['email_usuario'],$nombre, $apellido,$password);

}
}