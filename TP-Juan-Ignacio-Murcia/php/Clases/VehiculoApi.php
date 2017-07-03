<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'Vehiculo.php';
require_once './vendor/autoload.php';
class VehiculoApi
{
    public function AltaVehiculo($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $vehiculo = new vehiculo($ArrayDeParametros['dueño'],$ArrayDeParametros['patente'],$ArrayDeParametros['marca'],$ArrayDeParametros['color']);
        return $response->withJson($vehiculo->Guardar());
    }
    public function traerVehiculo($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        return $response->withJson(vehiculo::TraerVehiculoPorPatente($ArrayDeParametros['patente']));
    }
    
}
?>