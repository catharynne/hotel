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
        $categ = $this->contexto->get('categoria');
        $dataini = $this->contexto->get('datainicial');
        $datafim = $this->contexto->get('datafinal');
        if ($this->sessao->existe('usuario') && $this->sessao->get('usuario')['tipo'] == 'Administrador'){
            $agendas = new AgendaModelo();
            $categorias = new CategoriaModelo();
            if(isset($busca) || isset($categ) || isset($dataini) || isset($datafim)){
                $agendas = $agendas->procurarAgenda($busca,$categ,$dataini,$datafim);
                echo json_encode($agendas);
                return;
            }else{
                $categorias = $categorias->listar();
                $agendas = $agendas->listar();    
            }
            return $this->response->setContent($this->twig->render('agenda/index.php',['agendas' => $agendas,'categorias' => $categorias]));
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
        $titulo = $this->contexto->get('titulo');
        $assunto = $this->contexto->get('assunto');
        $data = $this->contexto->get('data');
        $hora = $this->contexto->get('hora').':00';
        $categoria = $this->contexto->get('categoria');
        $cliente = $this->contexto->get('cliente');
        if (isset($data)) {
            $date = $data;
            $date = explode('/', $date);
            $dia = $date[0];
            $mes = $date[1];
            $ano = $date[2];
            $data = $ano . '-' . $mes . '-' . $dia;
        }
        $agendaModelo = new AgendaModelo();
        $agenda = $agendaModelo->consultaDataHora($data,$hora);
        if($agenda != null){
            $erro['agenda'] ="Duplicidade de dia e hora!";
            echo json_encode($erro);
            return;
        }
        $agendaEntidade = new Agenda();
        $agendaEntidade->setTitulo(trim($titulo));
        $agendaEntidade->setAssunto(trim($assunto));
        $agendaEntidade->setData(trim($data));
        $agendaEntidade->setHora(trim($hora));
        $agendaEntidade->setCliente($cliente);
        $agendaEntidade->setCategoria($categoria);
        $agendaEntidade->setStatus(1);
        $agendaEntidade->setAdmin($this->sessao->get('usuario')['tipousuario']);
        if($agendaModelo->cadastrar($agendaEntidade) > 0){
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
            $destino = '/admin/agenda';
            $redirecionar = new RedirectResponse($destino);
            $redirecionar->send();
            return;   
        }
        $clientesModelo = new UsuarioModelo();
        $clientes = $clientesModelo->listarUsuarios();
        $categoriaModelo = new CategoriaModelo();
        $categorias = $categoriaModelo->listar();
        $agendaModelo = new AgendaModelo();
        $agenda = $agendaModelo->consultaId($id);
        if($agenda != null){
            return $this->response->setContent($this->twig->render('agenda/edit.php',['agenda' => $agenda,'categorias' => $categorias,'clientes' => $clientes]));    
        }
        $destino = '/admin/agenda';
        $redirecionar = new RedirectResponse($destino);
        $redirecionar->send();
        return;
    }
    public function atualizar(){
        $erro = [];
        $id = $this->contexto->get('idAgenda');
        $titulo = $this->contexto->get('titulo');
        $assunto = $this->contexto->get('assunto');
        $data = $this->contexto->get('data');
        $hora = $this->contexto->get('hora').':00';
        $categoria = $this->contexto->get('categoria');
        $status = $this->contexto->get('status');
        $cliente = $this->contexto->get('cliente');
        if (isset($data)) {
            $date = $data;
            $date = explode('/', $date);
            $dia = $date[0];
            $mes = $date[1];
            $ano = $date[2];
            $data = $ano . '-' . $mes . '-' . $dia;
        }
        $agendaModelo = new AgendaModelo();
        $agenda = $agendaModelo->consultaDataHoraComExcessaoId($data,$hora,$id);
        if($agenda != null){
            $erro['agenda'] ="Duplicidade de dia e hora!";
            echo json_encode($erro);
            return;
        }
        $agendaEntidade = new Agenda();
        $agendaEntidade->setId($id);
        $agendaEntidade->setStatus($status);
        $agendaEntidade->setTitulo(trim($titulo));
        $agendaEntidade->setAssunto(trim($assunto));
        $agendaEntidade->setData(trim($data));
        $agendaEntidade->setHora(trim($hora));
        $agendaEntidade->setCliente($cliente);
        $agendaEntidade->setCategoria($categoria);
        $agendaEntidade->setStatus($status);
        $agendaEntidade->setAdmin($this->sessao->get('usuario')['tipousuario']);
        if($agendaModelo->atualizar($agendaEntidade) > 0){
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
