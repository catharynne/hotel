<?php
namespace Hotel\Rotas;

use Symfony\Composer\Routing\Matcher\UrlMatcher;
use Symfony\Composer\Routing\RequestContext as coringa; // as nome e apelido para chamar a classe
use Symfony\Composer\Routing\RouteCollection;
use Symfony\Composer\Routing\Route;



$rotas = new RouteCollection();

$rotas->add('esporte', $rota = new Router('/esporte/{sufix}', 
        array('_controller' => 'Hotel\Controller\ControladorEsporte',"method"=>'msgInicial','sufix'=>'')));
        

$rotas->add('financeiro', $rota = new Router('/contasReceber', 
        array('_controller' => 'Hotel\Controller\ControladorContasReceber',"method"=>'msgInicial')));


return $rotas;

