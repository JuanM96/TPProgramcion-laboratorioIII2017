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
    function __conINTuct($id,$patente,$piso)
    {
        $this->id = $id;
        $this->patente = $patente;
        $this->piso = $piso;        
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
            $ret = "El Auto se estaciono exitosamente";
        }
        else {
            $ret = "ERROR, box ya ocupado";
        }
        return $ret;	
    }
    public static function TraerTodosboxes(){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `id`, `patente`, `piso` FROM `box` WHERE 1");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS, 'box');
    }
    public static function TraerboxPorid($id){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `id`, `patente`, `piso` FROM `box` WHERE id = :id");
        $consulta->bindValue(':id',$id, PDO::PARAM_INT);
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'box');
		$boxBuscado= $consulta->fetch();
		return $boxBuscado;
    }
    public function Verificarbox(){
        $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM `box` WHERE id = :id AND patente = :patente AND piso = :piso");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':patente', $this->patente, PDO::PARAM_INT);
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

}

?>