<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'Box.php';
require_once './vendor/autoload.php';
class BoxApi
{
    public function traerBoxesLibres($request, $response, $args){
        return $response->withJson(Box::TraerTodosBoxesLibres());
    }
    public function traerBoxesOcupadas($request, $response, $args){
        return $response->withJson(Box::TraerTodosboxesOcupados());
    }
}
?>