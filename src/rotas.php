<?php

namespace PPI2\Rotas;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$rotas = new RouteCollection();

$rotas->add('raiz', new Route('/', array(
    '_controller' => 'PPI2\Controller\ControllerIndex',
    'method' => 'index')));

$rotas->add('esporte', new Route('/esportes/{suffix}',
        array('_controller' => 'PPI2\Controller\ControllerEsporte',"method" => 'msgInicial', 'suffix' => '')));

$rotas->add('validaLogin', new Route('/validaLogin',
        array('_controller' => 'PPI2\Controller\ControllerUsuario',
            "method" => 'validaLogin')));
$rotas->add('admin', new Route('/admin',
        array('_controller' => 'PPI2\Controller\ControllerAdmin',
            "method" => 'index')));
$rotas->add('admin/usuario', new Route('/admin/usuario',
        array('_controller' => 'PPI2\Controller\ControllerUsuario',
            "method" => 'index')));
$rotas->add('admin/usuario/novo', new Route('/admin/usuario/novo',
        array('_controller' => 'PPI2\Controller\ControllerUsuario',
            "method" => 'create')));
$rotas->add('logout', new Route('/logout',
        array('_controller' => 'PPI2\Controller\ControllerUsuario',
            "method" => 'logout')));

$rotas->add('produtos', new Route('/produtos',
        array('_controller' => 'PPI2\Controller\ControllerEsporte',
            "method" => 'listarProdutos')));
$rotas->add('formCadastro', new Route('/formularioCadastro',
        array('_controller' => 'PPI2\Controller\ControllerCadastro',
            "method" => 'show')));
$rotas->add('cadastroProduto', new Route('/cadastro',
        array('_controller' => 'PPI2\Controller\ControllerCadastro',
            "method" => 'cadastro')));
/* $rotas->add('esporte', new Route('/financas', array('_controller' => 'PPI2\Controller\ControllerFinancas', "method"=>'msgInicialFinancas')));
  $rotas->add('esporte', new Route('/produtos', array('_controller' => 'PPI2\Controller\ControllerProduto', "method"=>'listar')));
 */
return $rotas;

