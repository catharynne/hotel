<?php

namespace Hotel\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Hotel\Modelos\ModeloCliente;
class ControllerFinanceiro {

    private $response;
    private $contexto;

    public function __construct(Response $response, RequestContext $contexto) {

        $this->response = $response;
        $this->contexto = $contexto;
    }

    public function msgInicial($parametro) {
        
        if(!id_numeric($parametro)&&($parametro !='')){
            
            $parametro='nao localizado';
            
        }
        
        return $this->response->setontent("Id : ".$parametro);//$this->contexto->getPathInfo());
        //passa a resposta e o que se sendo requisitado na url
        
    }

    public function listarClientes(){
        $modelo = new ModeloCliente();
        return $this->response->setContent($modelo->listarClientes());
    }
    
}
