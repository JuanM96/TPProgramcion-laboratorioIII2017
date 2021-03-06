<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'Box.php';
require_once './vendor/autoload.php';
class BoxApi
{
    public function AltaBox($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $box = new box($ArrayDeParametros['id'],$ArrayDeParametros['patente'],$ArrayDeParametros['piso']);
        return $response->withJson($box->Guardar());
    }
    public function TraerBoxesLibres($request, $response, $args){
        return $response->withJson(Box::TraerTodosBoxesLibres());
    }
    public function TraerBoxesOcupadas($request, $response, $args){
        return $response->withJson(Box::TraerTodosboxesOcupados());
    }
}
?>