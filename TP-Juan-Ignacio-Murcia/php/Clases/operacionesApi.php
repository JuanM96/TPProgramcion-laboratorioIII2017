<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'operaciones.php';
require_once 'Vehiculo.php';
require_once './vendor/autoload.php';
class OperacionApi
{
    public function AltaOperacion($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        //$vehiculo = Vehiculo::TraerVehiculoPorPatente($ArrayDeParametros['patente']);
		$vehiculo = new Vehiculo($ArrayDeParametros['duenio'],$ArrayDeParametros['patente'],$ArrayDeParametros['marca'],$ArrayDeParametros['color']);
		$itsOk = $vehiculo->Guardar();
		if ($itsOk['resultado']) {
            $box = new box($ArrayDeParametros['idBox'],$ArrayDeParametros['patente'],$ArrayDeParametros['idPiso']);
            if ($box->Guardar()['resultado']) {
                //$operacion = new operacion($ArrayDeParametros['idBox'],$ArrayDeParametros['idPiso'],$ArrayDeParametros['idEmpleado'],$vehiculo->id);
                return $response->withJson(operacion::Guardar($ArrayDeParametros['idBox'],$ArrayDeParametros['idPiso'],$ArrayDeParametros['idEmpleado'],$vehiculo->ID()));
            }
        }
        else{
            $ret['ERROR']="El vehiculo ya se encuentra en el estacionamiento";
            return $response->withJson($ret);
        }
		//return $response->withJson($ArrayDeParametros);
    }
    public function FinalizarOperacion($request, $response, $args){
        $patente = $ArrayDeParametros['patente'];
        $ret = $response->withJson(operacion::Salida($patente));
        if (is_int($ret)) {
            $operacion = operacion::TraerOperacionPorPatente($patente);
            Box::Borrar($operacion->idBox,$operacion->idPiso);
            Vehiculo::Borrar($patente);
            return $ret;
        }
    }
    public function TraerOperaciones($request, $response, $args){
        return $response->withJson(operacion::TraerTodasoperaciones());
    }
    public function TraerOperacionesPorEmpleado($request, $response, $args){
        return $response->withJson(operacion::TraeroperacionPorEmpleado($ArrayDeParametros['dni']));
    }
    public function TraerCantidadOpPorEmpleado($request, $response, $args){
        return $response->withJson(operacion::TraerCantOperacionPorEmpleado());
    }
    public function TraerBoxesAnalizadas($request, $response, $args){
        return $response->withJson(operacion::TraerBoxesAnalizadas());
    }
}
?>