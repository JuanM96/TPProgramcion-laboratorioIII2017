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

    function __construct($dueño = NULL,$patente = NULL,$marca = NULL,$color = NULL,$id = NULL)
    {
        if ($dueño != NULL && $patente != NULL && $marca != NULL && $color != NULL) {
			if($id != NULL){
				$this->id = $id;
			}
            $this->dueño = $dueño;
            $this->patente = $patente;
            $this->marca = $marca;
            $this->color = $color;
        }

    }
	public static function IDTraer($patente){
		$ret = Vehiculo::TraerVehiculoPorPatente($patente);
		return intval($ret->id);
	}
    public function Guardar(){
        $itsOk = false;
        $existeVehiculo = $this->VerificarVehiculo();
        if ($existeVehiculo['resultado'] == false) {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `vehiculo`(`dueño`, `patente`, `marca`, `color`) VALUES (:duenio,:patente,:marca,:color)");
		    $consulta->bindValue(':duenio', $this->dueño, PDO::PARAM_STR);
            $consulta->bindValue(':patente', $this->patente, PDO::PARAM_STR);
            $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
            $consulta->bindValue(':color', $this->color, PDO::PARAM_STR);
            $itsOk = $consulta->execute();
        }
        if ($itsOk) {
            $ret['resultado'] = true;
        }
        else {
            $ret['resultado'] = false;
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
	public function VerificarVehiculo(){
        $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM vehiculo WHERE patente = :patente");
        $consulta->bindValue(':patente', $this->patente, PDO::PARAM_STR);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "Vehiculo");
        if ($consulta->execute() && $ret['vehiculo'] = $consulta->fetch()) {
            $ret['resultado'] = true;
            
        }
        else {
            $ret['resultado'] = false;
        }
        return $ret;
    }

}

?>