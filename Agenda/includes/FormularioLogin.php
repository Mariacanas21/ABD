<?php 
require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';

class FormularioLogin extends Form
{

	public function __construct(){
		parent::__construct('formLogin');
	}

	protected function generaCamposFormulario($datosIniciales, $errores = array()){
		$nombreCorreo = $datos['email_usuario'] ?? '';
		$erroresGlobales = self::generaListaErroresGlobales($errores);
        $errorNombreCorreo = self::createMensajeError($errores, 'email_usuario', 'span', array('class' => 'error'));
        $errorPassword = self::createMensajeError($errores, 'contrasenia', 'span', array('class' => 'error'));
		$formulario = <<<EOF
			<fieldset>
				<legend> E-mail y contraseña</legend>
				$erroresGlobales
				<div class="grupo-control">
					<label>E-mail :</label> <input type="text" name="email_usuario" value="$nombreCorreo" />
					<p>$errorNombreCorreo</p>
				</div>
				<div class="grupo-control">
					<label> Contraseña :</label> <input type="password" name="contrasenia" />
					<p>$errorPassword</p>
				</div>
				<div class="grupo-control"><button type="submit" name="login">Entrar</button></div>
			</fieldset>
		EOF;
		return $formulario;
	}

	protected function procesaFormulario($datos){

		$result = array();
		$ok = true;
		$email_usuario = isset($datos['email_usuario']) ? $datos['email_usuario'] : null ;
		if (!$email_usuario)  {
		  
		  $ok = false;
		}
		$contrasenia = isset($datos['contrasenia']) ? $datos['contrasenia'] : null ;
		if ( !$contrasenia ) {
		  echo 'Usuario o contraseña incorrectos';
		  $ok = false;
		}
		if ( $ok ) {
			$usuario = Usuario::login ($email_usuario, $contrasenia);

			if ( !$usuario) {		
				echo "El usuario o el password no coinciden";
			} 
			else {
				
			$_SESSION['login'] = true;
			$_SESSION['nombre'] = $usuario->getNombre(); 
			$_SESSION['contrasenia'] = $contrasenia;
			$_SESSION['apellido'] = $usuario->getApellido();
			$_SESSION['email_usuario'] = $email_usuario;	
			$resultado = 'index.php';		
			}
		}
		return $result;
	  }
}