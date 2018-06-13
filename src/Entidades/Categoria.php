<?php

namespace PPI2\Entidades;

class Categoria {
    
    private $id;
    private $descricao;
    
    function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    
}
