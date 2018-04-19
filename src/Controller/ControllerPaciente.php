<?php

namespace Hotel\Controller;

class ControllerPaciente {

    private $response;
    private $contexto;
    private $twig;
    
     public function __construct(Response $response, RequestContext $contexto, Environment $twig) {
        
        $this->response = $response;
        $this->contexto = $contexto;
        $this->twig=$twig;
        
    }
    
}

