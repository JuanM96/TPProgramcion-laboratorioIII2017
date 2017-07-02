<?php
/**
 * 
 */
class Vehiculo
{
    public $id;
    public $dueño;
    public $patente;
    public $marca;
    public $color;

    function __construct($dueño,$patente,$marca,$color)
    {
        $this->dueño = $dueño;
        $this->patente = $patente;
        $this->marca = $marca;
        $this->color = $color;
    }
    public function Guardar(){
        $itsOk = false;
        $existeVehiculo = $this->VerificarVehiculo();
        if ($existeVehiculo['resultado'] == false) {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `vehiculo`(`dueño`, `patente`, `marca`, `color`)VALUES (:dueño,:patente,:marca,:color)");
		    $consulta->bindValue(':dueño', $this->dueño, PDO::PARAM_STR);
            $consulta->bindValue(':patente', $this->patente, PDO::PARAM_STR);
            $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
            $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
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
    public static function TraerVehiculoPorPatente($patente){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `id`, `dueño`, `patente`, `marca`, `color` FROM vehiculo WHERE patente = :patente");
        $consulta->bindValue(':patente',$patente, PDO::PARAM_STR);
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'vehiculo');
		$vehiculoBuscado= $consulta->fetch();
		return $vehiculoBuscado;
    }
    public static function TraerVehiculoPorId($id){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `dueño`, `patente`, `marca`, `color` FROM vehiculo WHERE id = :id");
        $consulta->bindValue(':id',$id, PDO::PARAM_STR);
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'vehiculo');
		$vehiculoBuscado= $consulta->fetch();
		return $vehiculoBuscado;
    }
    public static function Borrar($patente){
        $ret = "ERROR,PATENTE INEXISTENTE.";
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM `vehiculo` WHERE patente = :patente");
        $consulta->bindValue(':patente',$patente, PDO::PARAM_STR);		
		if($consulta->execute()){
            $ret = "Se Borro el vehiculo Exitosamente.";
        }
        return $ret;
    }

}

?>