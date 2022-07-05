
<?php 

require_once __DIR__.'/Form.php';
require_once __DIR__.'/Usuario.php';


class FormularioRegistro extends Form{

	public function __construct(){
		parent::__construct('formRegistro');
	}

	
	protected function generaCamposFormulario($datosIniciales, $errores = array()){
			$email_usuario = $datos['email'] ?? '';
			$nombre = $datos['nombre'] ?? '';
			$apellidos = $datos['apellidos'] ?? '';
			$erroresGlobales = self::generaListaErroresGlobales($errores);
			$errorNombreCorreo = self::createMensajeError($errores, 'nombreCorreo', 'span', array('class' => 'error'));
			$errorNombre = self::createMensajeError($errores, 'nombre', 'span', array('class' => 'error'));
			$errorPassword = self::createMensajeError($errores, 'password1', 'span', array('class' => 'error'));
			
			$formulario = <<<EOF
			<fieldset>
				$erroresGlobales
				<div class="grupo-control">
					<label> E-mail :</label> <input class="control" type="text" name="email_usuario" value="$email_usuario"/>
					<p>$errorNombreCorreo</p>
				</div>
				<div class="grupo-control">
					<label> Nombre : </label> <input class="control" type="text" name="nombre" value="$nombre"/>
					<p>$errorNombre</p>
				</div>
				<div class="grupo-control">
					<label> Apellidos : </label> <input class="control" type="text" name="apellido" value="$apellidos"/>
					<p>$errorNombre</p>
				</div>
				<div class="grupo-control">
					<label> Contraseña : </label> <input class="control" type="password" name="password" />
					<p>$errorPassword</p>
				</div>
				<div class="grupo-control">
					<label> Repite Contraseña : </label> <input class="control" type="password" name="password1" />
					<p>$errorPassword</p>
				</div>
				<div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>
				</fieldset>
		EOF;

		return $formulario;
	}


	protected function procesaFormulario($datos){
		$resultado = array();
		$email_usuario = $datos['email_usuario'] ?? null;
		$error=false;
		if ( empty($email_usuario) || mb_strlen($email_usuario) < 5 ) {
		echo "El correo tiene que tener una longitud de al menos 10 caracteres";
		}

		$nombre = $datos['nombre'] ?? null;
		if ( empty($nombre) ) {
			echo "El campo de nombre no puede estar vacio";
			$error=true;
		}

		$apellido = $datos['apellido'] ?? null;
		if(empty($apellido)){
			echo "El campo de apellido no puede estar vacio";
			$error=true;
		}

		$password = $datos['password'] ?? null;
		if ( empty($password) || mb_strlen($password) < 5 ) {
			echo "El password tiene que tener una longitud de al menos 5 caracteres.";
			$error=true;
		}
		$password2 = $datos['password1'] ?? null;
		if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
			echo "Los passwords deben coincidir";
			$error=true;
		}

		if ($error === false) {
		/* BUSCAUSUARIO */
			$usuario = Usuario::crea($email_usuario,$nombre,  $apellido, $password);

			if(!$usuario){
				echo "El usuario ya existe";
			}
			else{
				$resultado = "index.php";	
				Aplicacion::getInstancia()->login($usuario);
			}
		}
		return $resultado;
	}
}


?>