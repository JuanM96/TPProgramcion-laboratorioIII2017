<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'operaciones.php';
require_once 'Vehiculo.php';
require_once 'Empleado.php';
require_once './vendor/autoload.php';
class OperacionApi
{
    public function AltaOperacion($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        //$vehiculo = Vehiculo::TraerVehiculoPorPatente($ArrayDeParametros['patente']);
		$box = new box($ArrayDeParametros['idBox'],$ArrayDeParametros['patente'],$ArrayDeParametros['idPiso']);
		if(!$box->VerificarBox()['resultado']){
			$vehiculo = new Vehiculo($ArrayDeParametros['duenio'],$ArrayDeParametros['patente'],$ArrayDeParametros['marca'],$ArrayDeParametros['color']);
			if(!$box->VerificarBox()['resultado']){
				$itsOk = $vehiculo->Guardar();
			}
			else{
				$itsOK['resultado'] = false;
			}
			if ($itsOk['resultado']) {
				if ($box->Guardar()['resultado']) {
					//$operacion = new operacion($ArrayDeParametros['idBox'],$ArrayDeParametros['idPiso'],$ArrayDeParametros['idEmpleado'],$vehiculo->id);
					$empleado = empleado::TraerEmpleadoPorDni($ArrayDeParametros['dni']);
					return $response->withJson(operacion::Guardar($ArrayDeParametros['idBox'],$ArrayDeParametros['idPiso'],$empleado->id,Vehiculo::IDTraer($ArrayDeParametros['patente'])));
				}
			}
			else{
				$ret['resultado']="El vehiculo ya se encuentra en el estacionamiento";
				return $response->withJson($ret);
			}
        }
        else{
            $ret['resultado']="El Lugar ya esta ocupado";
            return $response->withJson($ret);
        }
		//return $response->withJson($ArrayDeParametros);
    }
    public function FinalizarOperacion($request, $response, $args){
		$ArrayDeParametros = $request->getParsedBody();
        $patente = $ArrayDeParametros['patente'];
        $ret = operacion::Salida($patente);
        if ($ret['resultado']) {
            Box::Borrar($patente);
            Vehiculo::Borrar($patente);
        }
		return $response->withJson($ret);
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