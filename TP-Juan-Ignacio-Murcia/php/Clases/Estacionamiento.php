<?php
/**
 * 
 */
include_once("AccesoDatos.php");
class estacionamiento
{
    public $nombre;
    public $cantPisos;
    public $cantBoxXPisos;
    function __construct($nombre,$cantPisos,$cantBoxXPisos)
    {
        $this->nombre = $nombre;
        $this->cantPisos = $cantPisos;
        $this->cantBoxXPisos = $cantBoxXPisos;
    }
    public function Guardar(){
        $itsOk = false;
        $existeEstacionamiento = $this->VerificarEstacionamiento();
        if ($existeEstacionamiento['resultado'] == false) {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `estacionamiento`(`nombre`, `cantPisos`, `cantBoxXPisos`)VALUES (:nombre,:cantPisos,:cantBoxXPisos)");
		    $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':cantPisos', $this->cantPisos, PDO::PARAM_INT);
            $consulta->bindValue(':cantBoxXPisos', $this->cantBoxXPisos, PDO::PARAM_INT);
            $itsOk = $consulta->execute();
        }
        if ($itsOk) {
            $ret = "El estacionamiento se guardo exitosamente";
        }
        else {
            $ret = "ERROR, ya existe";
        }
        return $ret;
    }
    public function VerificarEstacionamiento(){
        $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM `estacionamiento` WHERE nombre = :nombre AND cantPisos = :cantPisos AND cantBoxXPisos = :cantBoxXPisos");
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_INT);
        $consulta->bindValue(':cantPisos', $this->cantPisos, PDO::PARAM_INT);
        $consulta->bindValue(':cantBoxXPisos', $this->cantBoxXPisos, PDO::PARAM_INT);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "estacionamiento");
        if ($consulta->execute() && $ret['estacionamiento'] = $consulta->fetch()) {
            $ret['resultado'] = true;
            
        }
        else {
            $ret['resultado'] = false;
        }
        return $ret;
    }
    public static function TraerEstacionamientoPorNombre($nombre){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `nombre`, `cantPisos`, `cantBoxXPisos` FROM `estacionamiento` WHERE nombre = :nombre");
        $consulta->bindValue(':nombre',$id, PDO::PARAM_INT);
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'estacionamiento');
		$EstacionamientoBuscado= $consulta->fetch();
		return $EstacionamientoBuscado;
    }
}

?>