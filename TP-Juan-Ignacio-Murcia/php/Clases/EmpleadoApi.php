<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require_once 'Empleado.php';
require_once 'LogEmpleado.php';
require_once 'authentificadorJWT.php';
require_once './vendor/autoload.php';
class EmpleadoApi
{
    public function AltaEmpleado($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $Empleado = new empleado($ArrayDeParametros['nombre'],$ArrayDeParametros['apellido'],$ArrayDeParametros['email'],$ArrayDeParametros['dni'],$ArrayDeParametros['password'],$ArrayDeParametros['admin'],$ArrayDeParametros['suspendido']);
        return $response->withJson($Empleado->Guardar());
    }
    public function ModificarEmpleado($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $dniBuscado = $ArrayDeParametros['dniBuscado'];
        $Empleado = new empleado($ArrayDeParametros['nombre'],$ArrayDeParametros['apellido'],$ArrayDeParametros['email'],$ArrayDeParametros['dni'],$ArrayDeParametros['password'],$ArrayDeParametros['admin'],$ArrayDeParametros['suspendido']);
        return $response->withJson(Empleado::Modificar($Empleado,$dniBuscado));
    }
    public function BajaEmpleado($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $dni = $ArrayDeParametros['dni'];
        return $response->withJson(Empleado::Despedir($dni));
    }
    public function ActualizarEstadoEmpleado($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $dni = intval($ArrayDeParametros['dni']);
        $empleado = Empleado::TraerEmpleadoPorDni($dni);
        return $response->withJson($empleado->ActualizarEstado());
    }
    public function LogIn($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $dni = $ArrayDeParametros['dni'];
        $password = $ArrayDeParametros['password'];
        $ret = empleado::LogInVerificar($dni,$password);
        if ($ret['logIn']){
            $empleado = Empleado::TraerEmpleadoPorDni($dni);
            $ret['token'] = autentificadorJWT::crearToken(array(
                'dni'=> $empleado->dni,
                'admin' => $empleado->admin,
            ));
            $logEmpleado = new logEmpleado($dni);
            $logEmpleado->Guardar();
        }
		return $response->withJson($ret);
    }
    public function traerEmpleados($request, $response, $args){
        return $response->withJson(Empleado::TraerTodosEmpleados());
    }
    public function traerEmpleadoPorDni($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        return $response->withJson(Empleado::TraerEmpleadoPorDni($ArrayDeParametros['dni']));
    }
}
?>