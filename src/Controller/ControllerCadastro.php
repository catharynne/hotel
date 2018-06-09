<?php

namespace PPI2\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Twig\Environment;
use PPI2\Entidades\Produto;
use PPI2\Modelos\ModeloProdutos;
use PPI2\Util\Sessao;

class ControllerCadastro {

    private $response;
    private $contexto;
    private $twig;
    private $sessao;

    public function __construct(Response $response, Request $contexto, Environment $twig, Sessao $sessao) {
        $this->response = $response;
        $this->contexto = $contexto;
        $this->twig = $twig;
        $this->sessao = $sessao;
    }

    public function show() {
        if ($this->sessao->existe('Usuario'))
            return $this->response->setContent($this->twig->render('cadastro.twig'));
        else{
            $destino = '/login';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
            
        }
    }

    public function cadastro() {
        // validação


        $descricao = $this->contexto->get('descricao');
        $preco = $this->contexto->get('preco');
        // depois de validado
        $produto = new Produto($descricao, $preco);
        $modeloProduto = new ModeloProdutos();
        if ($id = $modeloProduto->cadastrar($produto))
            echo ("Produto $id inserido com sucesso");
        else
            echo "erro na inserção";
    }

}
