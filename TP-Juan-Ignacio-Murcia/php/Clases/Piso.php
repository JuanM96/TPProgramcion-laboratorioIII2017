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
}

?>