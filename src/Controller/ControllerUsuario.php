<?php

namespace PPI2\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Twig\Environment;
use PPI2\Modelos\UsuarioModelo;
use PPI2\Util\Sessao;
use PPI2\Validacao\ValidaCPFCNPJ;
use PPI2\Entidades\Usuario;

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
    public function index() {
        $busca = $this->contexto->get('busca');
        if ($this->sessao->existe('usuario') && $this->sessao->get('usuario')['tipo'] == 'Administrador'){
            $usuarios = new UsuarioModelo();
            if(isset($busca)){
                $usuarios = $usuarios->procurarUsuarios($busca);
                echo json_encode($usuarios);
                return;
            }else{
                $usuarios = $usuarios->listarUsuarios();    
            }
            return $this->response->setContent($this->twig->render('usuario/index.php',['usuarios' => $usuarios]));
        }
        else{
            $destino = '/';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
            
        }
    }
    public function create() {
        if ($this->sessao->existe('usuario') && $this->sessao->get('usuario')['tipo'] == 'Administrador'){
            return $this->response->setContent($this->twig->render('usuario/novo.php'));
        }
        else{
            $destino = '/';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
            
        }
    }
    public function salvar(){
        $erro = [];
        $email = $this->contexto->get('email');
        $senha = $this->contexto->get('senha');
        $nome = $this->contexto->get('nome');
        $cpf = preg_replace('/\D/', '', $this->contexto->get('cpf'));
        $telefone = preg_replace('/\D/', '', $this->contexto->get('telefone'));
        $verificaCpf = new ValidaCPFCNPJ($cpf);
        $verificaCpf = $verificaCpf->valida();
        if(!$verificaCpf){
            $erro['cpf'] = "cpf inválido!";
            echo json_encode($erro);
            return;
        }
        $usuarioModelo = new UsuarioModelo();
        $usuario = $usuarioModelo->consultaCpf($cpf);
        if($usuario != null){
            $erro['cpf'] ="Cpf já está cadastrado!";
            echo json_encode($erro);
            return;
        }
        $usuario = $usuarioModelo->consultaEmail($email);
        if($usuario != null){
            $erro['email'] ="Email já está cadastrado!";
            echo json_encode($erro);
            return;
        }
        $usuarioEntidade = new Usuario();
        $usuarioEntidade->setNome($nome);
        $usuarioEntidade->setTelefone($telefone);
        $usuarioEntidade->setCpf($cpf);
        $usuarioEntidade->setEmail($email);
        $usuarioEntidade->setSenha($senha);
        $usuarioEntidade->setTipoUsuario(2);
        if($usuarioModelo->cadastrar($usuarioEntidade) > 0){
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
            $destino = '/admin/usuario';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
            return;   
        }
        $usuarioModelo = new UsuarioModelo();
        $usuario = $usuarioModelo->consultaId($id);
        if($usuario != null){
            return $this->response->setContent($this->twig->render('usuario/edit.php',['usuario' => $usuario]));    
        }
        $destino = '/admin/usuario';
        $redirecionar = new RedirectResponse($destino);
        $redirecionar->send();
        return;
    }
    public function atualizar(){
        $erro = [];
        $id = $this->contexto->get('idUsuario');
        $email = $this->contexto->get('email');
        $nome = $this->contexto->get('nome');
        $cpf = preg_replace('/\D/', '', $this->contexto->get('cpf'));
        $telefone = preg_replace('/\D/', '', $this->contexto->get('telefone'));
        $verificaCpf = new ValidaCPFCNPJ($cpf);
        $verificaCpf = $verificaCpf->valida();
        if(!$verificaCpf){
            $erro['cpf'] = "cpf inválido!";
            echo json_encode($erro);
            return;
        }
        $usuarioModelo = new UsuarioModelo();
        $usuario = $usuarioModelo->consultaId($id);
        if($usuario == null){
            $erro['usuario'] = "Usuário não encontrado.";
            echo json_encode($erro);
            return;
        }
        $usuario = null;
        $usuario = $usuarioModelo->consultaCpfComExcessaoId($cpf,$id);
        if($usuario != null){
            $erro['cpf'] ="Cpf já está cadastrado!";
            echo json_encode($erro);
            return;
        }
        $usuario = null;
        $usuario = $usuarioModelo->consultaEmailComExcessaoId($email,$id);
        if($usuario != null){
            $erro['email'] ="Email já está cadastrado!";
            echo json_encode($erro);
            return;
        }
        $usuarioEntidade = new Usuario();
        $usuarioEntidade->setId($id);
        $usuarioEntidade->setNome($nome);
        $usuarioEntidade->setTelefone($telefone);
        $usuarioEntidade->setCpf($cpf);
        $usuarioEntidade->setEmail($email);
        $usuarioEntidade->setTipoUsuario(2);
        if($usuarioModelo->atualizar($usuarioEntidade) > 0){
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
        $usuarioModelo = new UsuarioModelo();
        $usuario = $usuarioModelo->validaUsuario($email,$senha);
        //se tiver o usuário cadastrado no banco e a senha estiver correta.
        if($usuario != null){
            //passa o usuário para a sessão.
            $this->sessao->add('usuario',$usuario);
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
