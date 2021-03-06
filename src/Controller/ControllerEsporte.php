<?php
 namespace PPI2\Controller;
 
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\HttpFoundation\Request;
 use PPI2\Modelos\ModeloProdutos;
 use Twig\Environment;
 use PPI2\Util\Sessao;
 
class ControllerEsporte {
    
    private $response;
    private $contexto;
    private $twig;
    
    public function __construct(Response $response, Request $contexto, Environment $twig){
        $this->response = $response;
        $this->contexto = $contexto;
        $this->twig = $twig;
    }
    
    public function msgInicial($parametro){
        
     if(!is_numeric($parametro) && $parametro != ''){
          $parametro = 'não localizado';
      }
      
      
 $sal = '25klP';
      
      return $this->response->setContent(sha1(md5('a'.$sal)));
    }
    
    
    public function listarProdutos(){
        $modelo = new ModeloProdutos();
        $dados = $modelo->listarProdutos();
        return $this->response->setContent($this->twig->render('produtos.twig', ['dados' => $dados]));
        
    }
}
