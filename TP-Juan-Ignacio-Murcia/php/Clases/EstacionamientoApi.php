<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'Estacionamiento.php';
require_once 'Piso.php';
require_once './vendor/autoload.php';
class EstacionamientoApi
{
    public function CrearEstacionamiento($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $est = new estacionamiento($ArrayDeParametros['cantPisos'],$ArrayDeParametros['cantBoxXPiso'],$ArrayDeParametros['precioXHora'],$ArrayDeParametros['precioXMedioDia'],$ArrayDeParametros['precioXDia']);
        //$response->getBody()->write(var_dump($ArrayDeParametros));
        //$piso = Piso::CrearPisos($ArrayDeParametros['cantPisos'],$ArrayDeParametros['cantBoxXPiso']);
        //echo $request->getAttribute('cantPisos');
        return $response->withJson($est->Guardar());
    }
    public function TraerEstacionamientoPorid($request, $response, $args){
        return $response->withJson(estacionamiento::TraerEstacionamientoPorid(1));
    }
}
?>