<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'Empleado.php';
require_once 'LogEmpleado.php';
require_once './vendor/autoload.php';
class EmpleadoApi
{
    public function AltaEmpleado($request, $response, $args){
        $Empleado = new empleado($request->getAttribute('nombre'),$request->getAttribute('apellido'),$request->getAttribute('email'),$request->getAttribute('dni'),$request->getAttribute('password'),$request->getAttribute('admin'),$request->getAttribute('suspendido'));
        return $response->withJson($Empleado->Guardar());
    }
    public function ModificarEmpleado($request, $response, $args){
        $dniBuscado = $request->getAttribute('dniBuscado');
        $Empleado = new empleado($request->getAttribute('nombre'),$request->getAttribute('apellido'),$request->getAttribute('email'),$request->getAttribute('dni'),$request->getAttribute('password'),$request->getAttribute('admin'),$request->getAttribute('suspendido'));
        return $response->withJson(Empleado::Modificar($Empleado,$dniBuscado));
    }
    public function BajaEmpleado($request, $response, $args){
        $dni = $request->getAttribute('dni');
        return $response->withJson(Empleado::Despedir($dni));
    }
    public function ActualizarEstadoEmpleado($request, $response, $args){
        $dni = $request->getAttribute('dni');
        $empleado = Empleado::TraerEmpleadoPorDni($dni);
        return $response->withJson($empleado->ActualizarEstado());
    }
    public function Login($request, $response, $args){
        $dni = $request->getAttribute('dni');
        $password = $request->getAttribute('password');
        $ret = $response->withJson(Empleado::LogInVerificar($dni,$password));
        if ($ret['resultado']) {
            $logEmpleado = new logEmpleado($dni);
            $logEmpleado->Guardar();
            return $ret;
        }
    }
    public function traerEmpleados($request, $response, $args){
        return $response->withJson(Empleado::TraerTodosEmpleados());
    }
    public function traerEmpleadoPorDni($request, $response, $args){
        return $response->withJson(Empleado::TraerEmpleadoPorDni($request->getAttribute('dni')));
    }
}
?>