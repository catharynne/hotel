<?php

namespace PPI2\Modelos;

use PPI2\Util\Conexao;
use PPI2\Entidades\Categoria;
use PDO;

class CategoriaModelo {

    function __construct() {

    }

    function listar() {

        try {
            $sql = 'select * from categoria order by descricao';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->execute();
            return $p_sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }
    function procurarCategorias($key) {
        try {
            $lista = [];
            if($key == ""){
                $sql = 'select * from categoria order by descricao';
            }else{
                $sql = "select * from categoria where descricao LIKE :pal order by descricao";
            }
            $p_sql = Conexao::getInstancia()->prepare($sql);
            if($key != ""){
                $p_sql->bindValue(':pal',"%".$key."%");
            }
            $p_sql->execute();
            $rows = $p_sql->fetchAll(PDO::FETCH_OBJ);
            foreach ($rows as $key => $row) {
                $lista[] = $row;
            }
            return $lista;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }

    
    function consultaId($id) {
        try {
            $sql = 'select * from categoria where id = :id';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':id',$id);
            $p_sql->execute();
            if ($p_sql->rowCount() > 0) {
                return $p_sql->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }
    function consultaDescricao($desc) {
        try {
            $sql = 'select * from categoria where descricao = upper(:desc)';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':desc',$desc);
            $p_sql->execute();
            if ($p_sql->rowCount() > 0) {
                return $p_sql->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }
    function consultaDescricaoComExcessao($desc,$id) {
        try {
            $sql = 'select * from categoria where descricao = upper(:desc) and id != :id';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':desc',$desc);
            $p_sql->bindValue(':id',$id);
            $p_sql->execute();
            if ($p_sql->rowCount() > 0) {
                return $p_sql->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }
    function cadastrar(Categoria $categoria) {

        try {
            $sql = 'insert into categoria (descricao) values 
            (upper(:descricao))';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':descricao', $categoria->getDescricao());
            if ($p_sql->execute())
                return Conexao::getInstancia()->lastInsertId();
            return null;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }
    function atualizar(Categoria $categoria) {

        try {
            $sql = 'update categoria set descricao = upper(:descricao) where id = :id';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':descricao', $categoria->getDescricao());
            $p_sql->bindValue(':id', $categoria->getId());
            if ($p_sql->execute())
                return $categoria->getId();
            return null;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }

}
