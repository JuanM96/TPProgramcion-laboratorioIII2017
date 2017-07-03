<?php
/**
 * 
 */
include_once("AccesoDatos.php");
class Piso
{
    public $id;
    public $cantBox;

    function __construct($id = null,$cantBox = null)
    {
        if ($id != null && $cantBox != null) {
            $this->id = $id;
            $this->cantBox = $cantBox;
        }
       
    }
    private function Guardar(){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `piso`(`id`, `cantBox`)VALUES (:id,:cantBox)");
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->bindValue(':cantBox', $this->cantBox, PDO::PARAM_INT);
        return $consulta->execute();
    }
    public static function CrearPisos($cant,$cantBox){
        for ($i=1; $i <= $cant ; $i++) { 
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `piso`(`id`, `cantBox`)VALUES (:id,:cantBox)");
            $consulta->bindValue(':id', $i, PDO::PARAM_INT);
            $consulta->bindValue(':cantBox', $cantBox, PDO::PARAM_INT);
            if($consulta->execute()){
                $ret['resultado'] = "Creado Correctamente";
            }
            else {
                $ret['resultado'] = "ERROR";
            }
        }
        return $ret;
    }
}

?>