<?php

namespace Hotel\Entidades;

class Cliente {

    private $id;
    private $nome;
    private $cpf;
    private $telefone;
    private $endereco;
    private $dataNascimento;
    private $historicoConsulta;

    function __construct() {
        
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getDataNascimento() {
        return $this->dataNascimento;
    }

    function getHistoricoConsulta() {
        return $this->historicoConsulta;
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

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    function setHistoricoConsulta($historicoConsulta) {
        $this->historicoConsulta = $historicoConsulta;
    }

    
    function listar() {
        return 'dados que viram do banco';
    }

}
