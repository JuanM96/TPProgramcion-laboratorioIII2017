<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require 'vendor/autoload.php';
require 'clases/AccesoDatos.php';
require 'clases/EmpleadoApi.php';
require 'clases/BoxApi.php';
require 'clases/EstacionamientoApi.php';
require 'clases/LogEmpleadoApi.php';
require 'clases/VehiculoApi.php';
require 'clases/operacionesApi.php';
require 'clases/VerificarJWT.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);
$app->add(function($request, $response, $next){
    $response = $next($request, $response);
    return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://juanmurciautn.hol.es/TP-Juan-Ignacio-Murcia/')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST');
});

/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/

$app->group('/ingreso', function () {
    $this->post('/logIn', \EmpleadoApi::class . ':LogIn');
});

$app->group('/empleado', function () {

    $this->post('/alta', \EmpleadoApi::class . ':AltaEmpleado');
    $this->post('/baja', \EmpleadoApi::class . ':BajaEmpleado');
    $this->post('/modificacion', \EmpleadoApi::class . ':ModificarEmpleado');
    $this->post('/suspender', \EmpleadoApi::class . ':ActualizarEstadoEmpleado');
    $this->get('/traerTodos', \EmpleadoApi::class . ':traerEmpleados');
    $this->post('/traerUno', \EmpleadoApi::class . ':traerEmpleadoPorDni');
})->add(\verificarJWT::class . ':VerificarToken')->add(\verificarJWT::class . ':VerificarTokenAdmin');

$app->group('/box', function () {
    $this->get('/traerBoxesLibres', \BoxApi::class . ':TraerBoxesLibres');
    $this->get('/traerBoxesOcupadas', \BoxApi::class . ':TraerBoxesOcupadas');
})->add(\verificarJWT::class . ':VerificarToken');

$app->group('/operacion', function () {
    $this->post('/iniciar', \OperacionApi::class . ':AltaOperacion');
    $this->post('/finalizar', \OperacionApi::class . ':FinalizarOperacion');
    $this->get('/traerTodas', \OperacionApi::class . ':TraerOperaciones');
})->add(\verificarJWT::class . ':VerificarToken');

$app->group('/operacionAdmin', function () {
    $this->post('/traerOpPorEmpleado', \OperacionApi::class . ':TraerOperacionesPorEmpleado');
    $this->get('/traerCantOpPorEmpleado', \OperacionApi::class . ':TraerCantidadOpPorEmpleado');
    $this->get('/traerBoxesAnalizadas', \OperacionApi::class . ':TraerBoxesAnalizadas');
})->add(\verificarJWT::class . ':VerificarToken')->add(\verificarJWT::class . ':VerificarTokenAdmin');

$app->group('/vehiculo', function () {
    $this->post('/traerPatente', \VehiculoApi::class . ':traerVehiculo');
})->add(\verificarJWT::class . ':VerificarToken');

$app->group('/logEmpleado', function () {
    $this->get('/traerLogs', \LogEmpleadoApi::class . ':TraerLogs');
    $this->post('/traerLogsPorEmpleado', \LogEmpleadoApi::class . ':TraerLogsPorDni');
})->add(\verificarJWT::class . ':VerificarToken')->add(\verificarJWT::class . ':VerificarTokenAdmin');

$app->group('/estacionamiento', function () {
    $this->post('/crear', \EstacionamientoApi::class . ':CrearEstacionamiento');
    $this->post('/traerPorId', \EstacionamientoApi::class . ':TraerEstacionamientoPorid');
})->add(\verificarJWT::class . ':VerificarToken')->add(\verificarJWT::class . ':VerificarTokenAdmin');

$app->run();
?>