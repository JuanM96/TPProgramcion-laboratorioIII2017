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

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
  
$app->group('/empleado', function () {

    $this->post('/alta', \EmpleadoApi::class . ':AltaEmpleado');
    $this->post('/baja', \EmpleadoApi::class . ':BajaEmpleado');
    $this->post('/modificacion', \EmpleadoApi::class . ':ModificarEmpleado');
    $this->post('/suspender', \EmpleadoApi::class . ':ActualizarEstadoEmpleado');
    $this->post('/logIn', \EmpleadoApi::class . ':LogIn');
    $this->get('/traerTodos', \EmpleadoApi::class . ':traerEmpleados');
    $this->get('/traerUno', \EmpleadoApi::class . ':traerEmpleadoPorDni');
});

$app->group('/box', function () {

    $this->post('/alta', \BoxApi::class . ':AltaBox');
    $this->get('/traerBoxesLibres', \BoxApi::class . ':TraerBoxesLibres');
    $this->get('/traerBoxesOcupadas', \BoxApi::class . ':TraerBoxesOcupadas');
});
$app->group('/operacion', function () {

    $this->post('/iniciar', \operacionesApi::class . ':AltaOperacion');
    $this->post('/finalizar', \operacionesApi::class . ':FinalizarOperacion');
    $this->get('/traerTodas', \operacionesApi::class . ':TraerOperaciones');
    $this->get('/traerOpPorEmpleado', \operacionesApi::class . ':TraerOperacionesPorEmpleado');
    $this->get('/traerCantOpPorEmpleado', \operacionesApi::class . ':TraerCantidadOpPorEmpleado');
    $this->get('/traerBoxesAnalizadas', \operacionesApi::class . ':TraerBoxesAnalizadas');
});
$app->group('/vehiculo', function () {
    $this->post('/alta', \VehiculoApi::class . ':AltaVehiculo');
    $this->get('/traerPatente', \VehiculoApi::class . ':traerVehiculo');
});
$app->group('/logEmpleado', function () {
    $this->get('/traerLogs', \LogEmpleadoApi::class . ':TraerLogs');
    $this->get('/traerLogsPorEmpleado', \LogEmpleadoApi::class . ':TraerLogsPorDni');
});

$app->group('/estacionamiento', function () {
    $this->post('/crear', \EstacionamientoApi::class . ':CrearEstacionamiento');
    $this->get('/traerPorId', \EstacionamientoApi::class . ':TraerEstacionamientoPorid');
});

$app->run();
?>