<?php

namespace PPI2\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Twig\Environment;
use PPI2\Modelos\CategoriaModelo;
use PPI2\Util\Sessao;
use PPI2\Entidades\Categoria;

class ControllerCategoria {

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

    public function index() {
        $busca = $this->contexto->get('buscacateg');
        if ($this->sessao->existe('usuario') && $this->sessao->get('usuario')['tipo'] == 'Administrador'){
            $categorias = new CategoriaModelo();
            if(isset($busca)){
                $categorias = $categorias->procurarCategorias($busca);
                echo json_encode($categorias);
                return;
            }else{
                $categorias = $categorias->listar();    
            }
            return $this->response->setContent($this->twig->render('categoria/index.php',['categorias' => $categorias]));
        }
        else{
            $destino = '/';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
            
        }
    }
    public function create() {
        if ($this->sessao->existe('usuario') && $this->sessao->get('usuario')['tipo'] == 'Administrador'){
            return $this->response->setContent($this->twig->render('categoria/novo.php'));
        }
        else{
            $destino = '/';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
            
        }
    }
    public function salvar(){
        $erro = [];
        $descricao = $this->contexto->get('descricao');
        $categoriaModelo = new CategoriaModelo();
        $categoria = $categoriaModelo->consultaDescricao($descricao);
        if($categoria != null){
            $erro['descricao'] ="Esta descrição já esta cadastrada!";
            echo json_encode($erro);
            return;
        }
        $categoriaEntidade = new Categoria();
        $categoriaEntidade->setDescricao(trim($descricao));
        if($categoriaModelo->cadastrar($categoriaEntidade) > 0){
            $erro['cadastro'] = "ok";
            echo json_encode($erro);
            return;
        }
        $erro['cadastro'] = "erro";
        echo json_encode($erro);
        return;
    }
    public function editar($id){
        $erro = [];
        if(!is_numeric($id) || $id < 1){
            $destino = '/admin/categoria';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
            return;   
        }
        $categoriaModelo = new CategoriaModelo();
        $categoria = $categoriaModelo->consultaId($id);
        if($categoria != null){
            return $this->response->setContent($this->twig->render('categoria/edit.php',['categoria' => $categoria]));    
        }
        $destino = '/admin/categoria';
        $redirecionar = new RedirectResponse($destino);
        $redirecionar->send();
        return;
    }
    public function atualizar(){
        $erro = [];
        $id = $this->contexto->get('idCategoria');
        $descricao = $this->contexto->get('descricao');
        $categoriaModelo = new CategoriaModelo();
        $categoria = $categoriaModelo->consultaId($id);
        if($categoria == null){
            $erro['categ'] = "Categoria não encontrado.";
            echo json_encode($erro);
            return;
        }
        $categoria = null;
        $categoria = $categoriaModelo->consultaDescricaoComExcessao($descricao,$id);
        if($categoria != null){
            $erro['descricao'] ="Esta categoria já está cadastrado!";
            echo json_encode($erro);
            return;
        }
        $categoriaEntidade = new Categoria();
        $categoriaEntidade->setId($id);
        $categoriaEntidade->setDescricao(trim($descricao));
        if($categoriaModelo->atualizar($categoriaEntidade) > 0){
            $erro['cadastro'] = "ok";
            echo json_encode($erro);
            return;
        }
        $erro['cadastro'] = "erro";
        echo json_encode($erro);
        return;
    }

    public function validaLogin(){
        //validação via AJAX com method = POST da página welcome.php
        $email = $this->contexto->get('email');
        $senha = $this->contexto->get('senha');
        $categoriaModelo = new CategoriaModelo();
        $categoria = $categoriaModelo->validaUsuario($email,$senha);
        //se tiver o usuário cadastrado no banco e a senha estiver correta.
        if($categoria != null){
            //passa o usuário para a sessão.
            $this->sessao->add('categoria',$usuario);
            if($usuario['tipo'] == 'Administrador'){
                echo('admin');
                return;
            }
        }else{
            //Usuário não encontrado, ou senha errada, retorna para welcome.php e mostra o erro de usuário ou senha.
            echo('errologin');
            return;
        }

    }
    public function logout(){
        //remove a chave['ppi2'] e inválida a sessão.
        $this->sessao->del();
        //redireciona para raiz '/'.
        $re = new RedirectResponse('/');
        $re->send();
    }

}
