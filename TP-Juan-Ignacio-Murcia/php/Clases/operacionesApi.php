<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'Operacion.php';
require_once 'Vehiculo.php';
require_once './vendor/autoload.php';
class OperacionApi
{
    public function AltaOperacion($request, $response, $args){
        $vehiculo = Vehiculo::TraerVehiculoPorPatente($request->getAttribute('patente'));
        $operacion = new operacion($request->getAttribute('idBox'),$request->getAttribute('idPiso'),$request->getAttribute('idEmpleado'),$vehiculo->id);
        return $response->withJson($operacion->Guardar());
    }
    public function FinalizarOperacion($request, $response, $args){
        $patente = $request->getAttribute('patente');
        $ret = $response->withJson(operacion::Salida($patente));
        if (is_int($ret)) {
            $operacion = operacion::TraerOperacionPorPatente($patente);
            Box::Borrar($operacion->idBox,$operacion->idPiso);
            Vehiculo::Borrar($patente);
            return $ret;
        }
    }
    public function Login($request, $response, $args){
        $dni = $request->getAttribute('dni');
        $password = $request->getAttribute('password');
        return $response->withJson(operacion::LogInVerificar($dni,$password));
    }
    public function traeroperacions($request, $response, $args){
        return $response->withJson(operacion::TraerTodosoperacions());
    }
    public function traeroperacionPorDni($request, $response, $args){
        return $response->withJson(operacion::TraerEmpleadoPorDni($request->getAttribute('dni')));
    }
}
?>