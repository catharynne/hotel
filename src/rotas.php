<?php
namespace Hotel\Rotas;

use Symfony\Composer\Routing\Matcher\UrlMatcher;
use Symfony\Composer\Routing\RequestContext as coringa; // as nome e apelido para chamar a classe
use Symfony\Composer\Routing\RouteCollection;
use Symfony\Composer\Routing\Route;

$rota = new Router('/esporte', array('_controller' => 'ControladorEsporte',"method"=>'msgInicial'));
$rotas = new RouteCollection();
$rotas->add('teste', $rota);

return $rotas;

