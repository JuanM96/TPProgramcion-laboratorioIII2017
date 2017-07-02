<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'LogEmpleado.php';
require_once './vendor/autoload.php';
class LogEmpleadoApi
{
    public function TraerLogs($request, $response, $args){
        return $response->withJson(Box::TraerTodosLog());
    }
    public function TraerLogsPorDni($request, $response, $args){
        return $response->withJson(Box::TraerLogPorDni($request->getAttribute('dni')));
    }
}
?>