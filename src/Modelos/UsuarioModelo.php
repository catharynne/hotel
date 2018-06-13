<?php

namespace PPI2\Modelos;

use PPI2\Util\Conexao;
use PPI2\Entidades\Usuario;
use PDO;

class UsuarioModelo {

    function __construct() {

    }

    function listarUsuarios() {

        try {
            $sql = 'select * from usuario order by nome';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->execute();
            return $p_sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }
    function procurarUsuarios($key) {
        try {
            $lista = [];
            if($key == ""){
                $sql = 'select * from usuario order by nome';
            }else{
                $sql = "select * from usuario where nome LIKE :pal or cpf LIKE :pal or telefone LIKE :pal or email LIKE :pal order by nome";
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
    function consultaCpf($cpf) {
        try {
            $sql = 'select * from usuario where cpf = :cpf';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':cpf',$cpf);
            $p_sql->execute();
            if ($p_sql->rowCount() > 0) {
                return $p_sql->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }
    function consultaEmail($email) {
        try {
            $sql = 'select * from usuario where email = lower(:email)';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':email',$email);
            $p_sql->execute();
            if ($p_sql->rowCount() > 0) {
                return $p_sql->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }
    function consultaCpfComExcessaoId($cpf,$id) {
        try {
            $sql = 'select * from usuario where cpf = :cpf and id != :id';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':cpf',$cpf);
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
    function consultaEmailComExcessaoId($email,$id) {
        try {
            $sql = 'select * from usuario where email = lower(:email) and id != :id';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':email',$email);
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
    function consultaId($id) {
        try {
            $sql = 'select * from usuario where id = :id';
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
    function cadastrar(Usuario $usuario) {

        try {
            $sql = 'insert into usuario (nome, cpf,telefone,email,tipousuario,senha) values 
            (upper(:nome), :cpf,:telefone,lower(:email),:tipousuario,md5(:senha))';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':nome', $usuario->getNome());
            $p_sql->bindValue(':cpf', $usuario->getCpf());
            $p_sql->bindValue(':telefone', $usuario->getTelefone());
            $p_sql->bindValue(':email', $usuario->getEmail());
            $p_sql->bindValue(':tipousuario', $usuario->getTipoUsuario());
            $p_sql->bindValue(':senha', $usuario->getSenha());
            if ($p_sql->execute())
                return Conexao::getInstancia()->lastInsertId();
            return null;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }
    function atualizar(Usuario $usuario) {

        try {
            $sql = 'update usuario set nome = upper(:nome), cpf = :cpf, telefone = :telefone, 
            email = lower(:email), tipousuario = :tipousuario where id = :id';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':nome', $usuario->getNome());
            $p_sql->bindValue(':cpf', $usuario->getCpf());
            $p_sql->bindValue(':telefone', $usuario->getTelefone());
            $p_sql->bindValue(':email', $usuario->getEmail());
            $p_sql->bindValue(':tipousuario', $usuario->getTipoUsuario());
            $p_sql->bindValue(':id', $usuario->getId());
            if ($p_sql->execute())
                return $usuario->getId();
            return null;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }

}
