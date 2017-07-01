<?php
/**
 * 
 */
include_once("AccesoDatos.php");
class Piso
{
    public $id;
    public $cantBox;

    function __construct($id,$cantBox)
    {
        $this->id = $id;
        $this->cantBox = $cantBox;
    }
    private function Guardar(){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `piso`(`id`, `cantBox`)VALUES (:id,:cantBox)");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':cantBox', $this->cantBox, PDO::PARAM_INT);
        return $consulta->execute();
    }
    public function CrearPisos($cant){
        for ($i=0; $i < $cant ; $i++) { 
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `piso`(`id`, `cantBox`)VALUES (:id,:cantBox)");
            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':cantBox', $this->cantBox, PDO::PARAM_INT);
            $consulta->execute();
        }
    }
}

?>