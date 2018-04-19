<?php

namespace Hotel\Modelos;

use Hotel\Util\Conexao;
use PDO;
class ModeloCliente {

    function __construct() {
        
    }

    function listarClientes() {

        try {
            $sql = 'select * from clientes';
            $p_sql = Conexao::getInstancia()->prepare($sql);
        $p_sql->execute();
        return $p_sql->fetchAll(PDO::FETCH_ASSOC);//fetch traz so a primeira linha fetchall traz todas;
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            return 'deu erro na conexao'.$exc;
        }
    }

}

// baixar composer, symfony, twing 
// cd /var/www/html/hotel composer require "twig/twig:^2.0"
