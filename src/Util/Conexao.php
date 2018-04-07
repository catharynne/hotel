<?php


class Conexao {
   private static $instancia;
   
   private function __construct() {
       
   }
   public static function getInstancia(){
       if(!isset(self::$instancia)){
           self::$instancia = new PDO("mysql:host=localhost;dbname=NOME_BANCO",'USUARIO','SENHA');
           self::$instancia->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES uft8");
           self::$instancia->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
           self::$instancia->setAttribute(PDO::ATTR_ORACLE_NULLS,PDO::NULL_EMPTY_STRING);
           
           
       }
       return self::$instancia;
   }
   public function close(){
      if(isset(self::$instancia)){
          self::$instancia = null;
          
      }
   }

}
