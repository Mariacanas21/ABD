
<?php
require_once __DIR__.'/Aplicacion.php';

class Usuario
{

    private $email_usuario;

    private $nombre;

    private $apellido;

    private $contrasenia;


    private function __construct($email_usuario,$nombre, $apellido,$contrasenia)
    {
        $this->email_usuario= $email_usuario;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->contrasenia = $contrasenia;
    }

    public static function login($email_usuario, $contrasenia)
    {
       
        $usuario = self::buscaCorreo($email_usuario);
        
        if ($usuario && $usuario->compruebaPassword($contrasenia)) {
           
            return $usuario;
        }
       
        return false;
    }

    //Para saber si ya tengo ese correo de usuario en la aplicación
    public  function buscaCorreo($email_usuario)
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
       
        $query = sprintf("SELECT * FROM usuario WHERE email_usuario = '$email_usuario'");
        $rs = $conn->query($query);
        $result = false;
        if ($rs) {
            if ( $rs->num_rows == 1) {
                $fila = $rs->fetch_assoc();
                $user = new Usuario($fila['email_usuario'],  $fila['nombre'], $fila['apellido'], $fila['contrasenia'],);
                $rs->free();
                return $user;
            }
            
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        }
        return false;
    }

    //Para saber si el usuario ya tiene a ese contacto en la agenda
    public static function buscaTelefono($telefono)
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $em = $_SESSION['email_usuario'];
        $query = ("SELECT telefono FROM contacto WHERE email_usuario = '$em'");
        $rs = $conn->query($query);

        $result = false;
        if ($rs) {
           while ( $fila = $rs->fetch_assoc()){
               if($fila["telefono"] == $telefono){ $result=true;}
           }
            
            
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        }
        return $result;
    }

    //Busqueda de un contacto en la agenda
    public static function buscarContacto($email,$telefono)
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $query = ("SELECT * FROM contacto WHERE email_usuario = '$email' and telefono ='$telefono'");
        $rs = $conn->query($query);

        
        if ($rs) {
           $file = $rs->fetch_row();
           return $file;
            
            
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
        }
        return false;
    }

    //Muestra la información de un contacto de nuestra agenda
    public static function muestrainformacionContacto($nombre,$apellido,$telefono){
        echo "<p> La información de ese contacto es </p> ";
        echo " <p> Nombre: ".$nombre."</p>";
        echo " <p> Apellido: ".$apellido."</p>";
        echo " <p> Telefono: ".$telefono."</p>";
    }



    public static function guarda($usuario)
    {
        echo $usuario->email_usuario;
        if ($usuario->email_usuario !== null) {
            return self::actualiza($usuario->email_usuario,$usuario->nombre,$usuario->apellido,$usuario->contrasenia);
        }
        return self::inserta($usuario);
    }

    //Comprueba si cuando me estoy registrando, ya tengo un correo igual en mi BD
    public static function crea($email_usuario, $nombre, $apellido, $contrasenia)
    {
        
        $user = self::buscaCorreo($email_usuario);
        if ($user) {
            return false;
        }
         
        $user = new Usuario($email_usuario,$nombre,  $apellido,$contrasenia);
        return self::inserta($user);
    }

     //Creación de un nuevo usuario
     private static function inserta($usuario)
    {

        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $query=sprintf("INSERT INTO usuario(email_usuario,nombre,apellido,contrasenia) VALUES('%s','%s', '%s','%s')"
            , $conn->real_escape_string($usuario->email_usuario)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->apellido)
            , $conn->real_escape_string ($usuario->contrasenia));
        $conn->query($query);
    
        
        return $usuario;
    }

   
    //El usuario crea un nuevo contacto
    public static function insertaContacto($nom,$ape,$tel, $email)
    {

        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $insertado = false;
        if(self::buscaCorreo($email)){
            $c= self::buscaTelefono($tel);
            if(!$c){
                $query="INSERT INTO contacto (telefono, email_usuario,nombre,apellido) VALUES ('$tel','$email','$nom','$ape')";
                $conn->query($query);
               
                echo "Contacto insertado";
                $insertado=true;
            }
            else{
                echo "Error al insertar en la BD: Ya tienes un contacto con ese número de telefono";
               
            }
        } 
       return $insertado;
    }
    
    //Actualizar los datos del usuario de la agenda
    public  static function actualiza($email,$nombre,$apellido, $contrasenia)
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE usuario set nombre='$nombre', apellido='$apellido', contrasenia='$contrasenia' where email_usuario='$email'");
        
        if($conn->query($query)){
            echo "Datos actualizados";

            $_SESSION['nombre'] = $nombre;
            $_SESSION['apellido'] = $apellido;
            $_SESSION['contrasenia'] = $contrasenia;
        }
        else{
            echo "Error al actualizar los datos";
        }
    }
    //Actualizar los datos del contacto
    public  static function actualizaContacto($id,$nombre,$apellido, $telefono)
    {
        $app = Aplicacion::getInstancia();
        $conn = $app->conexionBd();
        $query=sprintf("UPDATE INTO contacto  (nombre,apellido,telefono)  VALUES ('$nombre','$apellido','$telefono') where id_contacto = '$id'");
        
        if($conn->query($query)){
            echo "Datos actualizados";
        }
        else{
            echo "Error al actualizar los datos";
        }
    }

     //Eliminar un contacto de la agenda
     public  static function eliminarContacto($email,$telefono)
     {
         $app = Aplicacion::getInstancia();
         $conn = $app->conexionBd();
         
         if ( empty($telefono)|| mb_strlen($telefono) != 9){
            echo "Error al eliminar el contacto";
         }
         else{
         if(self::buscaCorreo($email)){
            $c= self::buscaTelefono($telefono);
            if($c){
                $query= "DELETE FROM contacto WHERE telefono= '$telefono' AND email_usuario = '$email'";
                $conn->query($query);
                echo "Contacto eliminado";
            }
            else{
                echo "No tienes ese número de teléfono en la agenda";
            }
        }
        }
     }

     
     //Mostrar el historial de llamadas de un contacto
     public  static function verHistorialContacto($email)
     {
         $app = Aplicacion::getInstancia();
         $conn = $app->conexionBd();
         $con = null;

         if(self::buscaCorreo($email)){
           
            $con .= "<table>";
				
			$con .= "<tr>";
			$con .= "<th> Telefono  </th>";
			$con .= "<th> Fecha </th>";
			$con .= "<th> Hora </th>";
            $con .= "<th> Duración (minutos) </th>";
			$con .= "</tr>";
            
                $query= "SELECT * FROM historial WHERE email_usuario = '$email' order by fecha ASC";
                $rs = $conn->query($query);

                if($rs->num_rows > 0){

                     while($fila = $rs->fetch_assoc()){
                        $con .= "<tr>";
                        $con .= "<td>" .$fila['telefono_contacto'] . ' ' ."</td>";
                        $con .= "<td>" .$fila['fecha'] . ' ' ."</td>";
                        $con .= "<td>" .$fila['hora'] . ' ' ."</td>";
                        $con .= "<td>" .$fila['duracion_min'] . ' ' ."</td>";
                        $con .= "</tr>";
                        $con .= '<br>';
                    }
                }
                else{
                    $con = "No tienes llamadas en su historial ";
                }
                $con .= "</table>";
		
        }
        else{
            $con = "Error al mostrar el contacto";
        }
        return $con;
     }

    public function getNombreCorreo()
    {
        return $this->email_usuario;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getcontrasenia()
    {
        return $this->contrasenia;
    }

    public function compruebaPassword($contrasenia)
    {
        if($contrasenia === $this->contrasenia) return true;
        return false;
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->contrasenia = ($nuevoPassword);
    }
    
    
}