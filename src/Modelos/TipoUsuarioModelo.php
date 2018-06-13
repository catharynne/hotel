<?php

namespace PPI2\Modelos;

use PPI2\Util\Conexao;
use PDO;

class TipoUsuarioModelo {

    function __construct() {
        
    }

    function listar() {

        try {
            $sql = 'select * from tipo_usuario order by tipo';
            $p_sql = Conexao::getInstancia()->prepare($sql);
            $p_sql->execute();
            return $p_sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $ex) {
            return 'deu erro na conexão:' . $ex;
        }
    }


}
