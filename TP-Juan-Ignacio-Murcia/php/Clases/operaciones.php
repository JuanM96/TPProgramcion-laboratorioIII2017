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

    function __construct($idBox = NULL ,$idPiso = NULL ,$idEmpleado = NULL ,$idVehiculo = NULL ,$entrada = NULL ,$salida = NULL,$costo = NULL)
    {
        if ($idBox != NULL  && $idPiso != NULL  && $idEmpleado != NULL  && $idVehiculo != NULL  && $entrada != NULL  && $salida != NULL && $costo != NULL) {
            $this->idBox = $idBox;
            $this->idPiso = $idPiso;
            $this->idEmpleado = $idEmpleado;
            $this->idVehiculo = $idVehiculo;
            $this->entrada = $entrada;
            $this->salida = $salida;
            $this->costo = $costo;
        }

    }
    public static function Guardar($idBox,$idPiso,$idEmpleado,$idVehiculo){
        $itsOk = false;
        //$existeoperacion = $this->VerificarOperacion();
        //if ($existeoperacion['resultado'] == false) {
            $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		    $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO `operaciones`(`idBox`, `idPiso`, `idEmpleado`, `idVehiculo`, `entrada`)VALUES (:idBox,:idPiso,:idEmpleado,:idVehiculo,NOW())");
		    $consulta->bindValue(':idBox', $idBox, PDO::PARAM_INT);
            $consulta->bindValue(':idPiso', $idPiso, PDO::PARAM_INT);
            $consulta->bindValue(':idEmpleado', $idEmpleado, PDO::PARAM_INT);
            $consulta->bindValue(':idVehiculo', $idVehiculo, PDO::PARAM_INT);
            $itsOk = $consulta->execute();
        //}
        if ($itsOk) {
            $ret['resultado'] = "La Operacion Se Guardo Exitosamente";
        }
        else {
            $ret['resultado'] = "ERROR, operacion Ya Existente";
        }
        return $ret;
		
    }
    public function VerificarOperacion(){
        $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM operaciones WHERE idBox = :idBox AND idPiso = idPiso AND salida = NULL");
        $consulta->bindValue(':idBox', $this->idBox, PDO::PARAM_INT);
        $consulta->bindValue(':idPiso', $this->idPiso, PDO::PARAM_INT);
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
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `idBox`, `idPiso`, `idEmpleado`, `idVehiculo`, `entrada`, `salida`, `costo` FROM operaciones WHERE 1");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_CLASS, 'operacion');
    }
    public static function TraeroperacionPorEmpleado($dni){
        $empleado = empleado::TraerEmpleadoPorDni($dni);
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `idBox`, `idPiso`, `idEmpleado`, `idVehiculo`, `entrada`, `salida`, `costo` FROM operaciones WHERE idEmpleado = :idEmpleado");
        $consulta->bindValue(':idEmpleado',$empleado->id, PDO::PARAM_INT);
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'operacion');
		$operacionBuscado= $consulta->fetch();
		return $operacionBuscado;
    }
    public static function Salida($patente){
        $ret['resultado'] = false;
        $Vehiculo = Vehiculo::TraerVehiculoPorPatente($patente);
        $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDatos->RetornarConsulta("UPDATE `operaciones` SET `salida`= NOW() WHERE costo = NULL AND idVehiculo = :idVehiculo");
        $consulta->bindValue(':idVehiculo', $Vehiculo->id, PDO::PARAM_INT);
        if ($consulta->execute()) {
            $costo = $this->CalcularCosto($Vehiculo->id,1);
            $objetoAccesoDatos2 = AccesoDatos::DameUnObjetoAcceso();
            $consulta2 = $objetoAccesoDatos->RetornarConsulta("UPDATE `operaciones` SET `costo`= :costo WHERE costo = NULL AND idVehiculo = :idVehiculo");
            $consulta2->bindValue(':costo', $costo , PDO::PARAM_INT);
            $consulta2->bindValue(':idVehiculo', $Vehiculo->id, PDO::PARAM_INT);
            if ($consulta2->execute()) {
                $ret['resultado'] = true;
                $ret['vehiculo'] = $vehiculo;
                $ret['costo'] = $costo;
            }
        }
        return $ret;
        
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
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT `idBox`, `idPiso`, `idEmpleado`, `idVehiculo`, `entrada`, `salida`, `costo` FROM operaciones WHERE idVehiculo = :idVehiculo AND salida = NULL");
        $consulta->bindValue(':idVehiculo',$vehiculo->id, PDO::PARAM_INT);
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_CLASS, 'operacion');
		$operacionBuscado= $consulta->fetch();
		return $operacionBuscado;
    }
    public static function TraerCantOperacionPorEmpleado(){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT E.Nombre, COUNT(O.id) AS cantidad FROM `operaciones` AS O , empleado AS E WHERE E.ID = O.idEmpleado GROUP BY O.idEmpleado");
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
		$operacionesBuscadas= $consulta->fetchAll();
        $json = json_encode($operacionesBuscadas);
		return $json;
    }
    public static function TraerBoxesAnalizadas(){
        $ret['boxMasUtilizada'] = operacion::BoxMasUltilizada();
        $ret['boxMenosUtilizada'] = operacion::BoxMenosUltilizada();
        $ret['boxsNuncaUtilizadas'] = operacion::BoxsNuncaUtilizadas();
        return $ret;
    }
    public static function BoxMenosUltilizada(){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT O.idPiso,O.idBox, COUNT(O.id) AS cantidad FROM `operaciones` AS O GROUP BY O.idPiso,O.idBox ORDER BY `cantidad` ASC LIMIT 1");
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
		$box= $consulta->fetch();
        return json_encode($box);
    }
    public static function BoxMasUltilizada(){
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT O.idPiso,O.idBox, COUNT(O.id) AS cantidad FROM `operaciones` AS O GROUP BY O.idPiso,O.idBox ORDER BY `cantidad` DESC LIMIT 1");
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
		$box= $consulta->fetch();
        return json_encode($box);
    }
    public static function BoxsNuncaUltilizadas(){
        $est = estacionamiento::TraerEstacionamientoPorid(1);
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT O.idPiso,O.idBox, COUNT(O.id) AS cantidad FROM `operaciones` AS O GROUP BY O.idPiso,O.idBox");
		$consulta->execute();
        $consulta->setFetchMode(PDO::FETCH_ASSOC);
		$boxes= $consulta->fetchAll();
        $box;
        $ret = array();
        for ($i=1; $i <= 3 ; $i++) { 
            for ($j=1; $j <= 20; $j++) { 
                $flag = false;
                for ($k=0; $k < count($boxes) ; $k++) { 
                    if($boxes[$k]['idPiso'] == $i && $boxes[$k]['idBox'] == $j){
                        $flag = true;
                    }
                }
                if(!$flag){
                    $box['idPiso'] = $i;
                    $box['idBox'] = $j;
                    array_push($ret,$box);
                }
            }
        }
        return $ret;
    }

}
