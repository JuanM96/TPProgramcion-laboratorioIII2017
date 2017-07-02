<?php
/**
 * 
 */
include_once("AccesoDatos.php");
include_once("Estacionamiento.php");
class logEmpleado
{
    public $dni;
    public $logIn;
    function __construct($dni)
    {
        $this->dni = $dni;
    }
    public function Guardar(){
        $itsOk = false;
        $existebox = $this->Verificarbox();
        if ($existebox['resultado'] == false) {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `logempleado`(`dni`, `logIn`)VALUES (:dni,NOW())");
		    $consulta->bindValue(':dni', $this->dni, PDO::PARAM_INT);
            $itsOk = $consulta->execute();
        }
        if ($itsOk) {
            $ret['resultado'] = "Correcto";
        }
        else {
            $ret['resultado'] = "ERROR";
        }
        return $ret;	
    }
    public static function TraerTodosLog(){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `dni`, `logIn` FROM `logempleado` WHERE 1");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS, 'logIn');
    }
    public static function TraerLogPorDni($dni){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `dni`, `logIn` FROM `logempleado` WHERE dni = :dni");
        $consulta->bindValue(':dni',$dni, PDO::PARAM_INT);
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'logEmpleado');
		$logEmpleadoBuscado= $consulta->fetch();
		return $logEmpleadoBuscado;
    }
    
}