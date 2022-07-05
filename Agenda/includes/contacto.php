

<?php
require_once __DIR__.'/Aplicacion.php';

class contacto
{

    private $nombreCorreo;

    private $nombre;

    private $apellido;

    private $telefono;

    private function __construct($nombreCorreo, $nombre, $apellido,$telefono)
    {
        $this->nombreCorreo= $nombreCorreo;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

      /*Borra un contacto, la imagen asociado a ese contacto y el historial de llamadas*/
  public function BorrarContacto(){
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    
    $query = sprintf("DELETE FROM contactos WHERE telefono_contacto=$this->telefono");
    $result = $conn->query($query);
    $query = sprintf("DELETE FROM historial WHERE telefono_contacto=$this->telefono");
   
    if ($conn->query($query)) 
        return true;
    else
        return 'Error al eliminar el contacto.';    
   }

   
     /* Añade un nuevo contacto a la agenda */
  public static function creaContacto($correo, $nombre, $apellido, $telefono) {
    $app = App::getSingleton();
    $conn = $app->conexionBd();
    $query = sprintf("INSERT INTO contacto (nombre,apellido,telefono,email_usuario) VALUES('%s','%s','%s','%s')",
        $conn->real_escape_string($nombre),
        $conn->real_escape_string($apellido),
        $conn->real_escape_string($telefono),
        $conn->real_escape_string($correo));
  
    if ($conn->query($query)) {
      return (new Contacto($correo, $nombre, $apellido, $telefono)); 
    }   
    else 
      return false;//'Error al crear el evento, fallo en la BD.';     
  }

  public function buscarContactosUsuario($email) {
    $app = Aplicacion::getInstancia();
    $conn = $app->conexionBd();
   
    $query = ("SELECT * FROM contacto  WHERE email_usuario='$email' ORDER BY nombre ASC");
    
    $result = $conn->query($query);
    
    return $result;

  }



}