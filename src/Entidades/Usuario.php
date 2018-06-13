<?php

namespace PPI2\Entidades;

class Usuario {
    
    private $id;
    private $nome;
    private $email;
    private $cpf;
    private $telefone;
    private $tipoUsuario;
    private $senha;
    
    
    function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getCpf(){
        return $this->cpf;
    }
    function getTelefone(){
        return $this->telefone;
    }
    function getTipoUsuario(){
        return $this->tipoUsuario;
    }
    function getSenha(){
        return $this->senha;
    }
    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }
    function setEmail($email){
        $this->email = $email;
    }
    function setTelefone($telefone){
        $this->telefone = $telefone;
    }
    function setSenha($senha){
        $this->senha = $senha;
    }
    function setTipoUsuario($tipoUsuario){
        $this->tipoUsuario = $tipoUsuario;
    }

    
}
