<?php
/**
 * 
 */
class Vehiculo
{
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

}

?>