<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'Box.php';
require_once './vendor/autoload.php';
class BoxApi
{
    public function AltaBox($request, $response, $args){
        $Box = new Box($request->getAttribute('id'),$request->getAttribute('patente'),$request->getAttribute('piso'));
        return $response->withJson($Box->Guardar());
    }
    public function ModificarBox($request, $response, $args){
        $dniBuscado = $request->getAttribute('dniBuscado');
        $Box = new Box($request->getAttribute('nombre'),$request->getAttribute('apellido'),$request->getAttribute('email'),$request->getAttribute('dni'),$request->getAttribute('password'),$request->getAttribute('admin'),$request->getAttribute('suspendido'));
        return $response->withJson(Box::Modificar($Box,$dniBuscado));
    }
    public function BajaBox($request, $response, $args){
        $dni = $request->getAttribute('dni');
        return $response->withJson(Box::Despedir($dni));
    }
    public function ActualizarEstadoBox($request, $response, $args){
        $dni = $request->getAttribute('dni');
        $Box = Box::TraerBoxPorDni($dni);
        return $response->withJson($Box->ActualizarEstado());
    }
    public function Login($request, $response, $args){
        $dni = $request->getAttribute('dni');
        $password = $request->getAttribute('password');
        return $response->withJson(Box::LogInVerificar($dni,$password));
    }
    public function traerBoxs($request, $response, $args){
        return $response->withJson(Box::TraerTodosBoxs());
    }
}
?>