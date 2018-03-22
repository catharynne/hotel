<?php
namespace Hotel;

 require _DIR_.'/../vendor/autoload.php';

use hotel\Entidades\Cliente;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


//rota apropriada  - > controlador que vai interceptar a requisição 
 
include 'rotas.php';

$response =Response::create();



$conteudo='asdasdasdasd';
$response->setContent($conteudo);
$response->send();
