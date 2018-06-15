<?php

namespace PPI2\Modelos;

use PPI2\Util\Conexao;
use PPI2\Entidades\Agenda;
use PDO;

class AgendaModelo {

    function __construct() {

    }

    function listar() {

        try {
            $sql = "select a.*,u.nome,c.descricao from agenda as a,usuario as u, categoria as c 
            where a.cliente = u.id and a.categoria = c.id order by a.data, a.hora";
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->execute();
            return $p_sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }
    function procurarAgendas($key) {
        try {
            $lista = [];
            if($key == ""){
                $sql = 'select * from agenda order by data,hora asc';
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
    
    function consultaDataHora($d,$h) {
        try {
            $sql = 'select * from agenda where data = :d and hora = :h';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':d',$d);
            $p_sql->bindValue(':h',$h);
            $p_sql->execute();
            if ($p_sql->rowCount() > 0) {
                return $p_sql->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }
    function consultaDataHoraComExcessaoId($d,$h,$id) {
        try {
            $sql = 'select * from agenda where data = :d and hora = :h and id != :id';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':d',$d);
            $p_sql->bindValue(':h',$h);
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
            $sql = "select a.*,u.nome,c.descricao from agenda as a,usuario as u, categoria as c 
            where a.cliente = u.id and a.categoria = c.id and a.id = :id";
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
    function cadastrar(Agenda $agenda) {

        try {
            $sql = 'insert into agenda (titulo, assunto,data,hora,cliente,categoria,admin,status) values 
            (upper(:titulo), :assunto,:data,:hora,:cliente,:categoria,:admin,:status)';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':titulo', $agenda->getTitulo());
            $p_sql->bindValue(':assunto', $agenda->getAssunto());
            $p_sql->bindValue(':data', $agenda->getData());
            $p_sql->bindValue(':hora', $agenda->getHora());
            $p_sql->bindValue(':cliente', $agenda->getCliente());
            $p_sql->bindValue(':categoria', $agenda->getCategoria());
            $p_sql->bindValue(':admin', $agenda->getAdmin());
            $p_sql->bindValue(':status', $agenda->getStatus());
            if ($p_sql->execute())
                return Conexao::getInstancia()->lastInsertId();
            return null;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }
    function atualizar(Agenda $agenda) {

        try {
            $sql = 'update agenda set titulo = upper(:titulo), assunto = :assunto, data = :data, 
            hora = :hora, cliente = :cliente, categoria = :categoria, admin = :admin, 
            status = :status where id = :id';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->bindValue(':id', $agenda->getId());
            $p_sql->bindValue(':titulo', $agenda->getTitulo());
            $p_sql->bindValue(':assunto', $agenda->getAssunto());
            $p_sql->bindValue(':data', $agenda->getData());
            $p_sql->bindValue(':hora', $agenda->getHora());
            $p_sql->bindValue(':cliente', $agenda->getCliente());
            $p_sql->bindValue(':categoria', $agenda->getCategoria());
            $p_sql->bindValue(':admin', $agenda->getAdmin());
            $p_sql->bindValue(':status', $agenda->getStatus());
            if ($p_sql->execute())
                return $agenda->getId();
            return null;
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }

}
