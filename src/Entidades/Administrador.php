<?php

namespace Hotel\Entidades;

class Administrador {
    private $id;
    private $nome;
    private $usuario;
    private $senhaAcesso;
    private $dataCadastramento;
    
    function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getSenhaAcesso() {
        return $this->senhaAcesso;
    }

    function getDataCadastramento() {
        return $this->dataCadastramento;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setSenhaAcesso($senhaAcesso) {
        $this->senhaAcesso = $senhaAcesso;
    }

    function setDataCadastramento($dataCadastramento) {
        $this->dataCadastramento = $dataCadastramento;
    }



}
