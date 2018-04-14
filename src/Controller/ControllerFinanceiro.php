<?php

namespace Hotel\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Hotel\Modelos\ModeloCliente;
use Twig\Environment;

class ControllerFinanceiro {

    private $response;
    private $contexto;
    private $twig;

    public function __construct(Response $response, RequestContext $contexto, Environment $twig) {
        
        $this->response = $response;
        $this->contexto = $contexto;
        $this->twig=$twig;
        
    }

    public function msgInicial($parametro) {

        if (!id_numeric($parametro) && ($parametro != '')) {

            $parametro = 'nao localizado';
        }

        return $this->response->setontent($this->twig->render('master')); //$this->contexto->getPathInfo());
        //passa a resposta e o que se sendo requisitado na url
    }

    public function listarClientes() {
        $modelo = new ModeloCliente();
        return $this->response->setContent($this->twig->render('master'));
        //$modelo->listarClientes());
    }

}
