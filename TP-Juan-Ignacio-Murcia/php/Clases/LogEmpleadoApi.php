<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'LogEmpleado.php';
require_once './vendor/autoload.php';
class LogEmpleadoApi
{
    public function TraerLogs($request, $response, $args){
        return $response->withJson(LogEmpleado::TraerTodosLog());
    }
    public function TraerLogsPorDni($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        return $response->withJson(LogEmpleado::TraerLogPorDni($ArrayDeParametros['dni']));
    }
}
?>