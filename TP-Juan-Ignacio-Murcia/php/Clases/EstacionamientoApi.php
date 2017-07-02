<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'Estacionamiento.php';
require_once './vendor/autoload.php';
class EstacionamientoApi
{
    public function CrearEstacionamiento($request, $response, $args){
        $est = new estacionamiento($request->getAttribute('cantPisos'),$request->getAttribute('cantBoxXPisos'),$request->getAttribute('precioXHora'),$request->getAttribute('precioXDia'),$request->getAttribute('precioXMedioDia'));
        return $response->withJson($est->Guardar());
    }
    public function TraerEstacionamientoPorid($request, $response, $args){
        return $response->withJson(estacionamient::TraerEstacionamientoPorid(1));
    }
}
?>