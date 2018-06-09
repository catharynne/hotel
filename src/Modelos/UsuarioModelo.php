<?php

namespace PPI2\Modelos;

use PPI2\Util\Conexao;
use PPI2\Entidades\Produto;
use PDO;

class UsuarioModelo {

    function __construct() {

    }

    function listarUsuarios() {

        try {
            $sql = 'select * from usuario';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->execute();
            return $p_sql->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }

    function validaUsuario($email,$senha){
        try{
            $sql = "select usuario.id, usuario.nome, usuario.email, usuario.telefone, usuario.cpf, 
            tipo_usuario.tipo from usuario, tipo_usuario where usuario.email = lower(:email) 
            and usuario.senha = md5(:senha) and tipo_usuario.id = usuario.tipousuario limit 1;";
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':email',$email);
            $p_sql->bindValue(':senha',$senha);
            $p_sql->execute();
            if ($p_sql->rowCount() > 0) {
                return $p_sql->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        }catch(Exception $ex){
            return 'deu erro na conexão: '.$ex;
        }
    }
    function tipoUsuario($id) {
        try {
            $sql = 'select tipo from tipo_usuario where id = :id';
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
    function cadastrar(Produto $produto) {

        try {
            $sql = 'insert into produtos (descricao, preco) values(:descricao, :preco)';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':descricao', $produto->getDescricao());
            $p_sql->bindValue(':preco', $produto->getPreco());
            if ($p_sql->execute())
                return Conexao::getInstancia()->lastInsertId();
            return null;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }

}
