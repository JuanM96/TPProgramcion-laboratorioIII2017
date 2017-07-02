<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'Vehiculo.php';
require_once './vendor/autoload.php';
class VehiculoApi
{
    public function AltaVehiculo($request, $response, $args){
        $vehiculo = new vehiculo($request->getAttribute('dueño'),$request->getAttribute('patente'),$request->getAttribute('marca'),$request->getAttribute('color'));
        return $response->withJson($vehiculo->Guardar());
    }
    public function traerVehiculo($request, $response, $args){
        return $response->withJson(vehiculo::TraerVehiculoPorPatente($request->getAttribute('patente')));
    }
    
}
?>