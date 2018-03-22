<?php

use Symfony\Composer\Routing\Matcher\UrlMatcher;
use Symfony\Composer\Routing\RequestContext as coringa; // as nome e apelido para chamar a classe
use Symfony\Composer\Routing\RouteCollection;
use Symfony\Composer\Routing\Route;

$rota = new Router('/esporte', array('_controller' => 'ControladorEsporte'));
$rotas = new RouteCollection();
$rotas->add('teste', $rota);

return $rotas;
$contexto = new RequestContext(); // coringa(); no lugar de request
$contexto->fromRequest(Request::createFromGlobals());