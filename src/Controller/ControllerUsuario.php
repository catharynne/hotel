<?php

namespace PPI2\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Twig\Environment;
use PPI2\Entidades\Produto;
use PPI2\Modelos\ModeloProdutos;
use PPI2\Modelos\UsuarioModelo;
use PPI2\Util\Sessao;

class ControllerUsuario {

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

    public function validaLogin(){
        //validação via AJAX com method = POST da página welcome.php
        $email = $this->contexto->get('email');
        $senha = $this->contexto->get('senha');
        $usuarioModelo = new UsuarioModelo();
        $usuario = $usuarioModelo->validaUsuario($email,$senha);
        //se tiver o usuário cadastrado no banco
        if($usuario != null){
            //passa o usuário para a sessão.
            $this->sessao->add('usuario',$usuario);
        }else{
            //Usuário não encontrado, retorna para welcome.php e mostra o erro de usuário ou senha.
            echo('errologin');
            return;
        }

    }
    public function logout(){
        $this->sessao->del();
        $re = new RedirectResponse('/');
        $re->send();
    }

}
