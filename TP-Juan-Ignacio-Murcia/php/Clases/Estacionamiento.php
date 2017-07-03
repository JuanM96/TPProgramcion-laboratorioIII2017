<?php
/**
 * 
 */
include_once("AccesoDatos.php");
class estacionamiento
{
    public $id;
    public $cantPisos;
    public $cantBoxXPisos;
    public $precioXHora;
    public $precioXDia;
    public $precioXMedioDia;
    function __construct($id,$cantPisos,$cantBoxXPisos,$precioXHora,$precioXMedioDia,$precioXDia)
    {
        $this->id = $id;
        $this->cantPisos = $cantPisos;
        $this->cantBoxXPisos = $cantBoxXPisos;
        $this->precioXHora = $precioXHora;
        $this->precioXMedioDia = $precioXMedioDia;
        $this->precioXDia = $precioXDia;
    }
    public function Guardar(){
        $itsOk = false;
        $existeEstacionamiento = $this->VerificarEstacionamiento();
        if ($existeEstacionamiento['resultado'] == false) {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `estacionamiento`(`id`, `cantPisos`, `cantBoxXPisos`, `precioXHora`, `precioXMedioDia`, `precioXDia`)VALUES (:id,:cantPisos,:cantBoxXPisos,:precioXHora,:precioXMedioDia,:precioXDia)");
		    $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindParam(':cantPisos', $this->cantPisos, PDO::PARAM_INT);
            $consulta->bindValue(':cantBoxXPisos', $this->cantBoxXPisos, PDO::PARAM_INT);
            $consulta->bindValue(':precioXHora', $this->precioXHora, PDO::PARAM_INT);
            $consulta->bindValue(':precioXDia', $this->precioXDia, PDO::PARAM_INT);
            $consulta->bindValue(':precioXMedioDia', $this->precioXMedioDia, PDO::PARAM_INT);
            $itsOk = $consulta->execute();
        }
        if ($itsOk) {
            $ret = "El estacionamiento se Creo exitosamente";
        }
        else {
            $ret = "ERROR, ya existe";
        }
        return $ret;
    }
    public function VerificarEstacionamiento(){
        $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM `estacionamiento` WHERE id = :id AND cantPisos = :cantPisos AND cantBoxXPisos = :cantBoxXPisos AND precioXHora = :precioXHora AND precioXMedioDia = :precioXMedioDia AND precioXDia = :precioXDia");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':cantPisos', $this->cantPisos, PDO::PARAM_INT);
        $consulta->bindValue(':cantBoxXPisos', $this->cantBoxXPisos, PDO::PARAM_INT);
        $consulta->bindValue(':precioXHora', $this->precioXHora, PDO::PARAM_INT);
        $consulta->bindValue(':precioXDia', $this->precioXDia, PDO::PARAM_INT);
        $consulta->bindValue(':precioXMedioDia', $this->precioXMedioDia, PDO::PARAM_INT);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "estacionamiento");
        if ($consulta->execute() && $ret['estacionamiento'] = $consulta->fetch()) {
            $ret['resultado'] = true;
            
        }
        else {
            $ret['resultado'] = false;
        }
        return $ret;
    }
    public static function TraerEstacionamientoPorid($id){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `id`, `cantPisos`, `cantBoxXPisos`, `precioXHora`, `precioXMedioDia`, `precioXDia` FROM `estacionamiento` WHERE id = :id");
        $consulta->bindValue(':id',$id, PDO::PARAM_INT);
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'estacionamiento');
		$EstacionamientoBuscado= $consulta->fetch();
		return $EstacionamientoBuscado;
    }
}

?>