
<?php

/**
 * Clase que mantiene el estado global de la aplicación.
 */
class Aplicacion
{
//	const ATTRIBUTO_SESSION_ATTRIBUTOS_PETICION = 'attsPeticion';

	private static $instancia;
	
	/**
	 * Devuele una instancia de {@see Aplicacion}.
	 * 
	 * @return Applicacion Obtiene la única instancia de la <code>Aplicacion</code>
	 */
	public static function getInstancia() {
		if (  !self::$instancia instanceof self) {
			self::$instancia = new self;
		}
		return self::$instancia;
	}

	/**
	 * @var array Almacena los datos de configuración de la BD
	 */
	private $bdDatosConexion;
	
	/**
	 * Almacena si la Aplicacion ya ha sido inicializada.
	 * 
	 * @var boolean
	 */
	private $inicializada = false;
	
	/**
	 * @var \mysqli Conexión de BD.
	 */
	private $conn;
	
	/**
	 * Evita que se pueda instanciar la clase directamente.
	 */
	private function __construct() {
	}
	
	/**
	 * Evita que se pueda utilizar el operador clone.
	 */
	public function __clone()
	{
		throw new Exception('No tiene sentido el clonado');
	}


	/**
	 * Evita que se pueda utilizar serialize().
	 */
	public function __sleep()
	{
		throw new Exception('No tiene sentido el serializar el objeto');
	}

	/**
	 * Evita que se pueda utilizar unserialize().
	 */
	public function __wakeup()
	{
		throw new Exception('No tiene sentido el deserializar el objeto');
	}


	public function email_usuario() {
		return  $_SESSION['email_usuario'];
	  }

	
	/**
	 * Inicializa la aplicación.
	 * 
	 * @param array $bdDatosConexion datos de configuración de la BD
	 */
	public function init($datosBD)
	{
        if ( ! $this->inicializada ) {
    	    $this->bdDatosConexion = $datosBD;    		
    		$this->inicializada = true;
			session_start();
        }
	}
	
	/**
	 * Cierre de la aplicación.
	 */
	public function shutdown()
	{
	    $this->compruebaInstanciaInicializada();
	    if ($this->conn !== null && ! $this->conn->connect_errno) {
	        $this->conn->close();
	    }
	}
	
	/**
	 * Comprueba si la aplicación está inicializada. Si no lo está muestra un mensaje y termina la ejecución.
	 */
	private function compruebaInstanciaInicializada()
	{
	    if (! $this->inicializada ) {
	        echo "Aplicacion no inicializada";
	        exit();
	    }
	}
	
	public function resuelve($path = '') {
		if (strlen($path) > 0 && $path[0] == '/') {
		  $path = mb_substr($path, 1);
		}
		return $path;
	  }

	/**
	 * Devuelve una conexión a la BD. Se encarga de que exista como mucho una conexión a la BD por petición.
	 * 
	 * @return \mysqli Conexión a MySQL.
	 */
	public function conexionBd()
	{
	    $this->compruebaInstanciaInicializada();
		if (! $this->conn ) {
			$bdHost = $this->bdDatosConexion['host'];
			$bdUser = $this->bdDatosConexion['user'];
			$bdPass = $this->bdDatosConexion['pass'];
			$bd = $this->bdDatosConexion['bd'];
			
			$this->conn = new \mysqli($bdHost, $bdUser, $bdPass, $bd);
			if ( $this->conn->connect_errno ) {
				echo "Error de conexión a la BD: (" . $this->conn->connect_errno . ") " . utf8_encode($this->conn->connect_error);
				exit();
			}
			if ( ! $this->conn->set_charset("utf8mb4")) {
				echo "Error al configurar la codificación de la BD: (" . $this->conn->errno . ") " . utf8_encode($this->conn->error);
				exit();
			}
		}
		return $this->conn;
	}

	//Inicio y cierre de sesion

	public function login(Usuario $user) {
		$_SESSION['login'] = true;
		$_SESSION['email_usuario'] = $user->getNombreCorreo();
		$_SESSION['nombre'] = $user->getNombre();
		$_SESSION['apellido'] = $user->getApellido();
		$_SESSION['contrasenia'] = $user->getcontrasenia();
	  }
	  public function logout() {
		unset($_SESSION['login']);
		unset($_SESSION['email_usuario']);
		unset($_SESSION['nombre']);
		unset($_SESSION['apellido']);
		unset($_SESSION['contrasenia']);
		session_destroy();
	  }
}