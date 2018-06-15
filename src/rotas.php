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

$rotas->add('admin/usuario/editar', new Route('/admin/usuario/editar/{suffix}',
        array('_controller' => 'PPI2\Controller\ControllerUsuario',"method" => 'editar', 'suffix' => '')));

$rotas->add('usuario/salvar', new Route('/usuario/salvar',
        array('_controller' => 'PPI2\Controller\ControllerUsuario',
            "method" => 'salvar')));
$rotas->add('usuario/atualizar', new Route('/usuario/atualizar',
        array('_controller' => 'PPI2\Controller\ControllerUsuario',
            "method" => 'atualizar')));
//-------INICIO ROTAS CATEGORIA
$rotas->add('admin/categoria', new Route('/admin/categoria',
        array('_controller' => 'PPI2\Controller\ControllerCategoria',
            "method" => 'index')));
$rotas->add('admin/categoria/novo', new Route('/admin/categoria/novo',
        array('_controller' => 'PPI2\Controller\ControllerCategoria',
            "method" => 'create')));

$rotas->add('admin/categoria/editar', new Route('/admin/categoria/editar/{suffix}',
        array('_controller' => 'PPI2\Controller\ControllerCategoria',"method" => 'editar', 'suffix' => '')));

$rotas->add('categoria/salvar', new Route('/categoria/salvar',
        array('_controller' => 'PPI2\Controller\ControllerCategoria',
            "method" => 'salvar')));
$rotas->add('categoria/atualizar', new Route('/categoria/atualizar',
        array('_controller' => 'PPI2\Controller\ControllerCategoria',
            "method" => 'atualizar')));
//-------FIM ROTAS CATEGORIA
//-------INICIO ROTAS AGENDA
$rotas->add('admin/agenda', new Route('/admin/agenda',
        array('_controller' => 'PPI2\Controller\ControllerAgenda',
            "method" => 'index')));
$rotas->add('admin/agenda/novo', new Route('/admin/agenda/novo',
        array('_controller' => 'PPI2\Controller\ControllerAgenda',
            "method" => 'create')));

$rotas->add('admin/agenda/editar', new Route('/admin/agenda/editar/{suffix}',
        array('_controller' => 'PPI2\Controller\ControllerAgenda',"method" => 'editar', 'suffix' => '')));

$rotas->add('agenda/salvar', new Route('/agenda/salvar',
        array('_controller' => 'PPI2\Controller\ControllerAgenda',
            "method" => 'salvar')));
$rotas->add('agenda/atualizar', new Route('/agenda/atualizar',
        array('_controller' => 'PPI2\Controller\ControllerAgenda',
            "method" => 'atualizar')));
//-------FIM ROTAS AGENDA
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

