<?php

namespace Hotel\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
class ControllerFinanceiro {

    private $response;
    private $contexto;

    public function __construct(Response $response, RequestContext $contexto) {

        $this->response = $response;
        $this->contexto = $contexto;
    }

    public function msgInicial() {
        
        return $this->response->setontent($this->contexto->getPathInfo());
        //passa a resposta e o que se sendo requisitado na url
        
    }

}
