<?php
namespace Hotel;

 require _DIR_.'/../vendor/autoload.php';

use hotel\Entidades\Cliente;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Composer\Routing\RequestContext;
use Symfony\Composer\Routing\Matcher\UrlMatcher;


//rota apropriada  - > controlador que vai interceptar a requisição 
 
include 'rotas.php';

$contexto = new RequestContext(); // coringa(); no lugar de request
$contexto->fromRequest(Request::createFromGlobals());




$matcher = new UrlMatcher($rotas,$contexto);

//print_r($matcher->($contexto->getPathInfo()));

$response =Response::create();

$conteudo='asdasdasdasd';
$response->setContent($conteudo);
$response->send();
