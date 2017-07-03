<?php
/**
 * 
 */
include_once("AccesoDatos.php");
class empleado
{
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $dni;
    public $password;
    public $admin;
    public $suspendido;

    function __construct($nom = null,$apellido = null,$email = null,$dni = null,$pass = null,$admin = null,$suspendido = null)
    {
        if ($nom != null && $apellido != null && $email != null && $dni != null && $pass != null && $admin != null && $suspendido != null) {
            $this->nombre = $nom;
            $this->apellido = $apellido;
            $this->email = $email;
            $this->dni = $dni;
            $this->password = $pass;
            $this->admin = $admin;
            $this->suspendido = $suspendido;
        }

    }
    public function Guardar(){
        $itsOk = false;
        $existeempleado = $this->Verificarempleado();
        if ($existeempleado['resultado'] == false) {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `empleado`(`Nombre`, `Apellido`, `Email`, `Dni`, `Password`, `admin`, `suspendido`)VALUES (:nombre,:apellido,:email,:dni,:password,:admin,:suspendido)");
		    $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
            $consulta->bindValue(':dni', $this->dni, PDO::PARAM_STR);
            $consulta->bindValue(':password', $this->password, PDO::PARAM_STR);
            $consulta->bindValue(':admin', $this->admin, PDO::PARAM_STR);
            $consulta->bindValue(':suspendido', $this->suspendido, PDO::PARAM_BOOL);
            $itsOk = $consulta->execute();
        }
        if ($itsOk) {
            $ret['respuesta'] = "El Empleado Se Guardo Exitosamente";
        }
        else {
            $ret['respuesta'] = "ERROR, Empleado Ya Existente";
        }
        return $ret;
		
    }
    public static function Modificar($nuevoEmpleado,$dni){
        $itsOk = false;
        $empleado = $this->TraerEmpleadoPorDni($dni);
        if ($empleado != false) {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE `empleado` SET `Nombre`=:nombre,`Apellido`=:apellido,`Email`=:email,`DNI`=:dni,`Password`=:password,`suspendido`=:suspendido,`Admin`=:admin WHERE dni = :dniBuscado");
		    $consulta->bindValue(':nombre', $nuevoEmpleado->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $nuevoEmpleado->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':email', $nuevoEmpleado->email, PDO::PARAM_STR);
            $consulta->bindValue(':dni', $nuevoEmpleado->dni, PDO::PARAM_STR);
            $consulta->bindValue(':dniBuscado', $dni, PDO::PARAM_STR);
            $consulta->bindValue(':password', $nuevoEmpleado->password, PDO::PARAM_STR);
            $consulta->bindValue(':admin', $nuevoEmpleado->admin, PDO::PARAM_STR);
            $consulta->bindValue(':suspendido', $nuevoEmpleado->suspendido, PDO::PARAM_INT);
            $itsOk = $consulta->execute();
        }
        if ($itsOk) {
            $ret['respuesta'] = "El Empeado Se Modifico Exitosamente";
        }
        else {
            $ret['respuesta'] = "ERROR, Empleado Inexistente";
        }
        return $ret;
		
    }
    public static function TraerTodosEmpleados(){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `ID` AS id, `Nombre` AS nombre, `Apellido` AS apellido, `Email` AS email, `Dni` AS dni, `Password` AS password, `admin`, `suspendido` FROM empleado WHERE 1");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS, 'empleado');
    }
    public static function TraerEmpleadoPorDni($dni){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `ID` AS id, `Nombre` AS nombre, `Apellido` AS apellido, `Email` AS email, `Dni` AS dni, `Password` AS password, `admin`, `suspendido` FROM empleado WHERE dni = :dni");
        $consulta->bindValue(':dni',$dni, PDO::PARAM_STR);
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'empleado');
		$empleadoBuscado= $consulta->fetch();
		return $empleadoBuscado;
    }
    public function VerificarEmpleado(){
        $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM empleado WHERE Dni = :dni");
        $consulta->bindValue(':dni', $this->dni, PDO::PARAM_STR);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "empleado");
        if ($consulta->execute() && $ret['empleado'] = $consulta->fetch()) {
            $ret['resultado'] = true;
            
        }
        else {
            $ret['resultado'] = false;
        }
        return $ret;
    }
    public static function LogInVerificar($dni,$password){
        $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT `ID` AS id, `Nombre` AS nombre, `Apellido` AS apellido, `Email` AS email, `Dni` AS dni, `Password` AS password, `admin`, `suspendido`  FROM empleado WHERE Dni = :dni AND Password = :password");
        $consulta->bindValue(':dni', $this->dni, PDO::PARAM_STR);
        $consulta->bindValue(':password', $this->password, PDO::PARAM_STR);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "empleado");
        if ($consulta->execute() && $ret['empleado'] = $consulta->fetch()) {
            $ret['logIn'] = true;
        }
        else {
            $ret['logIn'] = false;
        }
        return $ret;
    }
    public function ActualizarEstado(){
        $ret;
        $suspender = !($this->suspendido);
        // if ($this->suspendido) {
        //     $this->suspendido = false;
        // }
        // else{
        //     $this->suspendido = true;
        // }
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE `empleado` SET suspendido = :suspendido WHERE dni = :dni");
        $consulta->bindValue(':suspendido', $suspender, PDO::PARAM_BOOL);
        $consulta->bindValue(':dni', $this->dni, PDO::PARAM_INT);
        $ret['consulta'] = $consulta->execute();
        if ($suspender) {
            $ret['resultado'] = "Suspendido";
        }
        else{
            $ret['resultado'] = "Activo";
        }
        return $ret;
    }
    public static function Despedir($dni){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM `empleado` WHERE dni = :dni");
        $consulta->bindValue(':dni', $dni, PDO::PARAM_BOOL);
        if($consulta->execute())
        {
            $ret['resultado'] = "Despedido!";
        }
        else{
            $ret['resultado'] = "Empleado Inexistente";
        }
    }





}

?>