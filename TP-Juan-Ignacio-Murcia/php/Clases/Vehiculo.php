<?php
/**
 * 
 */
class Vehiculo
{
    public $dueño;
    public $patente;
    public $marca;
    public $tipo

    function __construct($dueño,$patente,$marca,$tipo)
    {
        $this->dueño = $dueño;
        $this->patente = $patente;
        $this->marca = $marca;
        $this->tipo = $this->tipoVehiculo($tipo);
    }

    function tipoVehiculo($tipo)
    {
        $ret;
        if ($tipo == 0) {
            $ret = "Auto";
        } 
        elseif ($tipo == 1) {
            $ret = "Moto"
        }
        elseif($tipo == "Auto"){
            $ret = 0
        }
        elseif($tipo == "Moto"){
            $ret = 1
        }
        return $ret;
        
        
    }
}

?>