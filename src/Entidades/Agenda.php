<?php

namespace PPI2\Entidades;
use PPI2\Modelos\UsuarioModelo;
use PPI2\Entidades\Usuario;

class Agenda {
    
    private $id;
    private $titulo;
    private $assunto;
    private $cliente;
    private $admin;
    private $data;
    private $hora;
    private $status;
    private $categoria;
    
    
    function __construct() {
        //$this->cliente = new Usuario();
    }
    
    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getAssunto() {
        return $this->assunto;
    }

    function getCliente(){
        return $this->cliente;
    }
    function getAdmin(){
        return $this->admin;
    }
    function getData(){
        return $this->data;
    }
    function getHora(){
        return $this->hora;
    }
    function getStatus(){
        return $this->status;
    }
    function getCategoria(){
        return $this->categoria;
    }
    function setId($id) {
        $this->id = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }
    function setAssunto($assunto){
        $this->assunto = $assunto;
    }
    function setAdmin($admin){
        $this->admin = $admin;
    }
    function setHora($hora){
        $this->hora = $hora;
    }
    function setData($data){
        $this->data = $data;
    }
    function setStatus($status){
        $this->status = $status;
    }
    function setCategoria($categoria){
        $this->categoria = $categoria;
    }
    
}