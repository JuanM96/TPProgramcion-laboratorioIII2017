<?php
/**
 * 
 */
include_once("AccesoDatos.php");
include_once("Estacionamiento.php");
class box
{
    public $id;
    public $patente;
    public $piso;
    function __construct($id = null ,$patente = null ,$piso = null)
    {
        if ($patente != null && $piso != null) {
			
            $this->id = $id;
            $this->patente = $patente;
            $this->piso = $piso;        
        }

    }
    public function Guardar(){
        $itsOk = false;
        $existebox = $this->Verificarbox();
        if ($existebox['resultado'] == false) {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `box`(`id`, `patente`, `piso`)VALUES (:id,:patente,:piso)");
		    $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':patente', $this->patente, PDO::PARAM_INT);
            $consulta->bindValue(':piso', $this->piso, PDO::PARAM_INT);
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
    public static function TraerTodosboxesOcupados(){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `id`, `patente`, `piso` FROM `box` WHERE 1");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS, 'box');
    }
    public static function TraerTodosBoxesLibres(){
        $ret = array();
        $est= Estacionamiento::TraerEstacionamientoPorid(1);
        for ($i=1; $i <= $est->cantPisos; $i++) {
            $piso['pisoNum'] = $i;
            $piso['boxesLibres'] = array();
            for ($j=1; $j <= $est->cantBoxXPisos; $j++) { 
                if(Box::TraerboxPoridYPiso($j,$i) == false){
                    array_push($piso['boxesLibres'],$j);
                }
            }
            array_push($ret,$piso);
        }
        return $ret;
    }
    public static function TraerboxPoridYPiso($id,$piso){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `id`, `patente`, `piso` FROM `box` WHERE id = :id AND piso = :piso");
        $consulta->bindValue(':id',$id, PDO::PARAM_INT);
        $consulta->bindValue(':piso',$piso, PDO::PARAM_INT);
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'box');
		$boxBuscado= $consulta->fetch();
		return $boxBuscado;
    }
    public function Verificarbox(){
        $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM `box` WHERE id = :id AND piso = :piso");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':piso', $this->piso, PDO::PARAM_INT);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "box");
        if ($consulta->execute() && $ret['box'] = $consulta->fetch()) {
            $ret['resultado'] = true;
            
        }
        else {
            $ret['resultado'] = false;
        }
        return $ret;
    }
    public static function Borrar($patente){
        $ret = "ERROR,ID INEXISTENTE.";
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM `box` WHERE patente = :patente");
        $consulta->bindValue(':patente',$patente, PDO::PARAM_INT);	
		if($consulta->execute()){
            $ret = "Se Borro el box Exitosamente.";
        }
        return $ret;
    }


    
}

?>