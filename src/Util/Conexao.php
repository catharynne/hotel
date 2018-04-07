<?php


class Conexao {
   private static $instancia;
   
   private function __construct() {
       
   }
   public static function getInstancia(){
       if(!self::$instancia){
           self::$instancia = new PDO("mysql:host=localhost;dbname=NOME_BANCO",'USUARIO','SENHA');
           self::$instancia->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES uft8");
           self::$instancia->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES uft8");
           
           
       }
       return self::$instancia;
   }

}
