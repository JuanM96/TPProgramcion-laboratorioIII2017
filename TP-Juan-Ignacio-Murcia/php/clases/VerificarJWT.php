<?php
/**
 * 
 */
require_once 'authentificadorJWT.php';
require_once 'vendor/autoload.php';
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
class VerificarJWT
{
    public function VerificarToken($request, $response, $next){
        if($request->hasHeader('token')){
            $token = $request->getHeader('token')[0];
            try{
                $datos = autentificadorJwt::decodificarToken($token);
            }
            catch(Exception $e){
                return $response->withJson($e->getMessage(), 511);
            }
            if($datos){
                $request = $request->withAttribute('datos', $datos);
                return $next($request, $response);    
            }
            return $response->withJson("Token Caducado",400);
        }
        else{
            $token = $request->getAttribute('route')->getArgument('token');
            if($token){
                try{
                    $datos = autentificadorJWT::decodificarToken($token);
                }
                catch(Exception $e){
                    return $response->withJson($e->getMessage(), 511);
                }
                $request = $request->withAttribute('datos', $datos);
                return $next($request, $response);
            }
        }
        return $response->withJson("No se encuentra el token", 400);
    }
	public function VerificarTokenAdmin($request, $response, $next){
        if($request->hasHeader('token')){
            $token = $request->getHeader('token')[0];
            try{
                $datos = autentificadorJwt::decodificarToken($token);
            }
            catch(Exception $e){
                return $response->withJson($e->getMessage(), 511);
            }
            if($datos){
                if ($datos->admin == '1') {
                    $request = $request->withAttribute('datos', $datos);
                    return $next($request, $response);
                }
                else {
                    return $response->withJson("No tienes permiso para realizar esta accion", 400);
                }
            }
            return $response->withJson("Token Caducado",400);
        }
        else {
            return $response->withJson("Pasame un token!", 400);
        }
    }
}


?>