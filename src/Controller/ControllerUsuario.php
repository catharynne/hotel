<?php

namespace PPI2\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Twig\Environment;
use PPI2\Modelos\UsuarioModelo;
use PPI2\Modelos\AgendaModelo;
use PPI2\Modelos\CategoriaModelo;
use PPI2\Util\Sessao;
use PPI2\Validacao\ValidaCPFCNPJ;
use PPI2\Entidades\Usuario;
use PPI2\Modelos\TipoUsuarioModelo;

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

    public function index() {
        if ($this->sessao->existe('usuario') && $this->sessao->get('usuario')['tipo'] == 'Administrador'){
        }else{
            $re = '/';
            $redirecionar = new RedirectResponse($re);
            $redirecionar->send();
            return; 
        }
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
    public function registro() {
        if (!$this->sessao->existe('usuario')){
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
        if ($this->sessao->existe('usuario') && $this->sessao->get('usuario')['tipo'] == 'Administrador'){
        }else{
            $re = '/';
            $redirecionar = new RedirectResponse($re);
            $redirecionar->send();
            return; 
        }
        $erro = [];
        if(!is_numeric($id) || $id < 1){
            $destino = '/admin/usuario';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
            return;   
        }
        $tipoUsuarioModelo = new TipoUsuarioModelo();
        $tipoUsuario = $tipoUsuarioModelo->listar();
        $usuarioModelo = new UsuarioModelo();
        $usuario = $usuarioModelo->consultaId($id);
        if($usuario != null){
            return $this->response->setContent($this->twig->render('usuario/edit.php',['usuario' => $usuario,'permissoes' => $tipoUsuario]));    
        }
        $destino = '/admin/usuario';
        $redirecionar = new RedirectResponse($destino);
        $redirecionar->send();
        return;
    }
    public function atualizar(){
        if ($this->sessao->existe('usuario') && $this->sessao->get('usuario')['tipo'] == 'Administrador'){
        }else{
            $re = '/';
            $redirecionar = new RedirectResponse($re);
            $redirecionar->send();
            return; 
        }
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
        $email = $this->contexto->get('email');
        $senha = $this->contexto->get('senha');
        $usuarioModelo = new UsuarioModelo();
        $usuario = $usuarioModelo->validaUsuario($email,$senha);
       if($usuario != null){
           $this->sessao->add('usuario',$usuario);
            if($usuario['tipo'] == 'Administrador'){
                echo('admin');
                return;
            }else if($usuario['tipo'] == 'Usuario'){
                echo('cliente');
                return;
            }else{
                echo('invalido');
                return;
            }
        }else{
            echo('errologin');
            return;
        }

    }
    public function logout(){
        $this->sessao->del();
        $re = new RedirectResponse('/');
        $re->send();
    }
    public function agenda(){
        $busca = $this->contexto->get('buscaagenda');
        $categ = $this->contexto->get('categoria');
        $dataini = $this->contexto->get('datainicial');
        $datafim = $this->contexto->get('datafinal');
        if ($this->sessao->existe('usuario')){
            $agendas = new AgendaModelo();
            $categorias = new CategoriaModelo();
            if(isset($busca) || isset($categ) || isset($dataini) || isset($datafim)){
                $agendas = $agendas->procurarAgendaUsuario($busca,$categ,$dataini,$datafim,$this->sessao->get('usuario')['id']);
                echo json_encode($agendas);
                return;
            }else{
                $categorias = $categorias->listar();
                $agendas = $agendas->getAgenda($this->sessao->get('usuario')['id']);    
            }
            return $this->response->setContent($this->twig->render('usuario/agenda.php',['agendas' => $agendas,'categorias' => $categorias]));
        }
        else{
            $destino = '/';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
            
        }
    }
    public function showAgenda($id){
        if(!is_numeric($id) || $id < 1){
            $destino = '/agenda';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
            return;   
        }
        if ($this->sessao->existe('usuario')){
            $agendas = new AgendaModelo();
            $agenda = $agendas->getAgendaUsuario($id,$this->sessao->get('usuario')['id'])[0];
            if($agenda != null){
                return $this->response->setContent($this->twig->render('agenda/show.php',['agenda' => $agenda]));
            }
            $destino = '/agenda';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
        }
        else{
            $destino = '/';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
            
        }
    }
}
