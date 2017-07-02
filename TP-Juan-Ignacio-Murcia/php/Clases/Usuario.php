<?php
/**
 * 
 */
include_once("AccesoDatos.php");
class empleado
{
    private $admin;
    public $nombre;
    public $apellido;
    public $email;
    public $dni;
    private $password;
    public $turno;

    function __construct($nom,$apellido,$email,$dni,$pass,$turno)
    {
        $this->nombre = $nom;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->dni = $dni;
        $this->password = $pass;
        $this->turno = $turno;
        if ($nom == "admin" && $pass == "admin") {
            $this->admin == 1;
        }
        else {
            $this->admin == 0;
        }
    }
    public function Guardar(){
        $itsOk = false;
        $existeempleado = $this->Verificarempleado();
        if ($existeempleado['resultado'] == false) {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `empleado`(`Nombre`, `Apellido`, `Email`, `Dni`, `Password`, `turno`)VALUES (:nombre,:apellido,:email,:dni,:password,:turno)");
		    $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
            $consulta->bindValue(':dni', $this->dni, PDO::PARAM_STR);
            $consulta->bindValue(':password', $this->password, PDO::PARAM_STR);
            $consulta->bindValue(':turno', $this->password, PDO::PARAM_STR);
            $itsOk = $consulta->execute();
        }
        if ($itsOk) {
            $ret = "El Empeado Se Guardo Exitosamente";
        }
        else {
            $ret = "ERROR, Empleado Ya Existente";
        }
        return $ret;
		
    }
    public static function TraerTodosEmpleados(){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `Nombre`, `Apellido`, `Email`, `Dni`, `Password`, `turno`, `admin` FROM empleado WHERE 1");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS, 'empleado');
    }
    public static function TraerEmpleadoPorDni($dni){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `Nombre`, `Apellido`, `Email`, `Dni`, `Password`, `turno`, `admin` FROM empleado WHERE dni = :dni");
        $consulta->bindValue(':dni',$dni, PDO::PARAM_STR);
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'empleado');
		$empleadoBuscado= $consulta->fetch();
		return $empleadoBuscado;
    }
    public function VerificarEmpleado(){
        $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM empleado WHERE Nombre = :nombre AND Apellido = :apellido AND Email = :email AND Dni = :dni AND Password = :password AND turno = :turno");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
        $consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
        $consulta->bindValue(':dni', $this->dni, PDO::PARAM_STR);
        $consulta->bindValue(':password', $this->password, PDO::PARAM_STR);
        $consulta->bindValue(':turno', $this->turno, PDO::PARAM_STR);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "empleado");
        if ($consulta->execute() && $ret['empleado'] = $consulta->fetch()) {
            $ret['resultado'] = true;
            
        }
        else {
            $ret['resultado'] = false;
        }
        return $ret;
    }



}

?>