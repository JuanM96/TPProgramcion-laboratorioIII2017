<?php
/**
 * 
 */
 include_once("AccesoDatos.php");
class Usuario
{
    public $admin;
    public $nombre;
    public $apellido;
    public $email;
    public $dni;
    public $password;

    function __construct($nom,$apellido,$pass,$email,$dni)
    {
        $this->nombre = $nom;
        $this->apellido = $apellido
        $this->email = $email;
        $this->dni = $dni;
        $this->password = $pass;
        if ($nom == "admin" $$ $pass == "admin") {
            $this->admin == 1;
        }
        else {
            $this->admin == 0;
        }
    }

    function static GuardarUsuario($usuario){
        $objetoGuardarDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoGuardarDatos->RetornarConsulta("INSERT INTO `Empleados`(`Nombre`, `Apellido`, `Email`, `DNI`, `Contraseña`, `Admin`) VALUES ('".$usuario->nombre."', '".$usuario->apellido."', '".$usuario->email."', '".$usuario->dni."', '".$usuario->password."', '".$usuario->admin."')");
        return $consulta->execute();
    }



}

?>