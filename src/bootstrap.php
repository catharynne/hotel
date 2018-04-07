<?php

namespace Hotel;

require _DIR_ . '/../vendor/autoload.php';

use hotel\Entidades\Cliente;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Composer\Routing\RequestContext;
use Symfony\Composer\Routing\Matcher\UrlMatcher;

//rota apropriada  - > controlador que vai interceptar a requisição 

include 'rotas.php';

$contexto = new RequestContext(); // coringa(); no lugar de request
$contexto->fromRequest(Request::createFromGlobals());

$response = Response::create();


$matcher = new UrlMatcher($rotas, $contexto);
//print_r($matcher->match('/esporte'));

try {
    $atributos = $matcher->match($contexto->getPathInfo()); //pega a url 
    
    $controller = $atributos['_controller'];
    
    $method = $atributos['method'];
    
    $parametros = $atributos['sufix'];
    
    $obj = new $controller($response, $contexto);
    
    $obj->$method($parametros = '');
    
} catch (Exception $ex) {
    
    $response->SetContent('Not Found 404', Response::HTTP_NOT_FOUND);
    
}

//print_r($matcher->($contexto->getPathInfo()));
//$conteudo = 'asdasdasdasd';
//$response->setContent($conteudo);
$response->send();
