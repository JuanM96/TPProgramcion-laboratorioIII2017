<?php
/**
 * 
 */
class Piso
{
    public $admin;
    public $nombre;
    public $password;

    function __construct($nom,$pass)
    {
        $this->nombre = $nom;
        $this->password = $pass;
        if ($nom == "admin" && $pass == "admin") {
            $this->admin == 1;
        }
        else {
            $this->admin == 0;
        }
    }
}

?>