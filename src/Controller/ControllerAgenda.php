<?php

namespace PPI2\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Twig\Environment;
use PPI2\Modelos\AgendaModelo;
use PPI2\Modelos\CategoriaModelo;
use PPI2\Modelos\UsuarioModelo;
use PPI2\Util\Sessao;
use PPI2\Entidades\Agenda;

class ControllerAgenda {

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
        $busca = $this->contexto->get('buscaagenda');
        if ($this->sessao->existe('usuario') && $this->sessao->get('usuario')['tipo'] == 'Administrador'){
            $agendas = new AgendaModelo();
            if(isset($busca)){
                $agendas = $agendas->procurarAgenda($busca);
                echo json_encode($agendas);
                return;
            }else{
                $agendas = $agendas->listar();    
            }
            return $this->response->setContent($this->twig->render('agenda/index.php',['agendas' => $agendas]));
        }
        else{
            $destino = '/';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
            
        }
    }
    public function create() {
        if ($this->sessao->existe('usuario') && $this->sessao->get('usuario')['tipo'] == 'Administrador'){
            $categoriasModelo = new CategoriaModelo();
            $categorias = $categoriasModelo->listar();
            $usuarioModelo = new UsuarioModelo();
            $usuarios = $usuarioModelo->listarUsuarios();
            return $this->response->setContent($this->twig->render('agenda/novo.php',['categorias' => $categorias,'clientes' => $usuarios]));
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
        $usuarioModelo = new AgendaModelo();
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
        $usuarioEntidade->setNome(trim($nome));
        $usuarioEntidade->setTelefone(trim($telefone));
        $usuarioEntidade->setCpf(trim($cpf));
        $usuarioEntidade->setEmail(trim($email));
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
        $tipoUsuarioModelo = new TipoAgendaModelo();
        $tipoUsuario = $tipoUsuarioModelo->listar();
        $usuarioModelo = new AgendaModelo();
        $usuario = $usuarioModelo->consultaId($id);
        if($usuario != null){
            return $this->response->setContent($this->twig->render('agenda/edit.php',['usuario' => $usuario,'permissoes' => $tipoUsuario]));    
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
        $tipo_usuario = $this->contexto->get('tipousuario');
        $cpf = preg_replace('/\D/', '', $this->contexto->get('cpf'));
        $telefone = preg_replace('/\D/', '', $this->contexto->get('telefone'));
        $verificaCpf = new ValidaCPFCNPJ($cpf);
        $verificaCpf = $verificaCpf->valida();
        if(!$verificaCpf){
            $erro['cpf'] = "cpf inválido!";
            echo json_encode($erro);
            return;
        }
        $usuarioModelo = new AgendaModelo();
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
        $usuarioEntidade->setNome(trim($nome));
        $usuarioEntidade->setTelefone(trim($telefone));
        $usuarioEntidade->setCpf(trim($cpf));
        $usuarioEntidade->setEmail(trim($email));
        $usuarioEntidade->setTipoUsuario($tipo_usuario);
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
        $usuarioModelo = new AgendaModelo();
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
