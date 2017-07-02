<?php
/**
 * 
 */
include_once("AccesoDatos.php");
include_once("Estacionamiento.php");
include_once("Box.php");
include_once("Vehiculo.php");
include_once("Empleado.php");
class operacion
{
    public $idBox;
    public $idPiso;
    public $idEmpleado;
    public $idVehiculo;
    public $entrada;
    public $salida;
    public $costo;

    function __construct($idBox,$idPiso,$idEmpleado,$idVehiculo,$entrada,$salida = null,$costo = null)
    {
        $this->idBox = $idBox;
        $this->idPiso = $idPiso;
        $this->idEmpleado = $idEmpleado;
        $this->idVehiculo = $idVehiculo;
        $this->entrada = $entrada;
        if ($salida != null && $costo != null) {
            $this->salida = $salida;
            $this->costo = $costo;
        }

    }
    public function Guardar(){
        $itsOk = false;
        $existeoperacion = $this->VerificarOperacion();
        if ($existeoperacion['resultado'] == false) {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `operacion`(`idBox`, `idPiso`, `idEmpleado`, `idVehiculo`, `entrada`)VALUES (:idBox,:idPiso,:idEmpleado,:idVehiculo,NOW())");
		    $consulta->bindValue(':idBox', $this->idBox, PDO::PARAM_STR);
            $consulta->bindValue(':idPiso', $this->idPiso, PDO::PARAM_STR);
            $consulta->bindValue(':idEmpleado', $this->idEmpleado, PDO::PARAM_STR);
            $consulta->bindValue(':idVehiculo', $this->idVehiculo, PDO::PARAM_STR);
            $itsOk = $consulta->execute();
        }
        if ($itsOk) {
            $ret = "La Operacion Se Guardo Exitosamente";
        }
        else {
            $ret = "ERROR, operacion Ya Existente";
        }
        return $ret;
		
    }
    public function VerificarOperacion(){
        $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM operacion WHERE idBox = :idBox AND idPiso = idPiso AND salida = NULL");
        $consulta->bindValue(':idBox', $this->idBox, PDO::PARAM_STR);
        $consulta->bindValue(':idPiso', $this->idPiso, PDO::PARAM_STR);
        $consulta->setFetchMode(PDO::FETCH_CLASS, "operacion");
        if ($consulta->execute() && $ret['operacion'] = $consulta->fetch()) {
            $ret['resultado'] = true;
            
        }
        else {
            $ret['resultado'] = false;
        }
        return $ret;
    }
    public static function TraerTodasoperaciones(){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `idBox`, `idPiso`, `idEmpleado`, `idVehiculo`, `entrada`, `salida`, `costo` FROM operacion WHERE 1");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS, 'operacion');
    }
    public static function TraeroperacionPorEmpleado($dni){
        $empleado = empleado::TraerEmpleadoPorDni($dni);
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `idBox`, `idPiso`, `idEmpleado`, `idVehiculo`, `entrada`, `salida`, `costo` FROM operacion WHERE idEmpleado = :idEmpleado");
        $consulta->bindValue(':idEmpleado',$empleado->id, PDO::PARAM_STR);
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'operacion');
		$operacionBuscado= $consulta->fetch();
		return $operacionBuscado;
    }
    public static function Salida($patente){
        $Vehiculo = Vehiculo::TraerVehiculoPorPatente($patente);
        $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDatos->RetornarConsulta("UPDATE `operaciones` SET `salida`= NOW() WHERE costo = NULL AND idVehiculo = :idVehiculo");
        $consulta->bindValue(':idVehiculo', $Vehiculo->id, PDO::PARAM_STR);
        if ($consulta->execute()) {
            $costo = $this->CalcularCosto($Vehiculo->id,1);
            $objetoAccesoDatos2 = AccesoDatos::DameUnObjetoAcceso();
            $consulta2 = $objetoAccesoDatos->RetornarConsulta("UPDATE `operaciones` SET `costo`= :costo WHERE costo = NULL AND idVehiculo = :idVehiculo");
            $consulta2->bindValue(':costo', $costo , PDO::PARAM_STR);
            $consulta2->bindValue(':idVehiculo', $Vehiculo->id, PDO::PARAM_STR);
            if ($consulta2->execute()) {
                return $costo;
            }
        }
        else {
            return "Vehiculo Inexistente";
        }
        
    }
    public function CalcularCosto($idVehiculo,$idEstacionamiento){
        $vehiculo = Vehiculo::TraerVehiculoPorid($idVehiculo);
        $estacionamiento = Estacionamiento::TraerEstacionamientoPorid($idEstacionamiento);
        $objetoAccesoDatos = accesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT HOUR(TIMEDIFF(salida, entrada)) as `dif` FROM operaciones WHERE costo = NULL AND patente = :patente");
        $consulta->bindValue(":patente", $vehiculo->patente, PDO::PARAM_STR);
        if($consulta->execute()){
            $numero = $consulta->fetch();
        }
        if($numero['dif'] > 24){
            return $estacionamiento->precioXdia;
        }
        elseif($numero['dif'] > 12){
            return $estacionamiento->precioXMedioDia;
        }
        elseif($numero['dif'] == 0){
            return $estacionamiento->precioXHora;
        }
        else{
            return ($numero['dif'] * $this->precioXHora);
        }
    }

    public static function TraerOperacionPorPatente($patente){
        $Vehiculo = Vehiculo::TraerVehiculoPorPatente($patente);
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `idBox`, `idPiso`, `idEmpleado`, `idVehiculo`, `entrada`, `salida`, `costo` FROM operacion WHERE idVehiculo = :idVehiculo AND salida = NULL");
        $consulta->bindValue(':idVehiculo',$vehiculo->id, PDO::PARAM_STR);
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'operacion');
		$operacionBuscado= $consulta->fetch();
		return $operacionBuscado;
    }

}
