<?php

class Conexao{
    private $host ='localhost';
    private $dbname = 'meu_blog';
    private $user = 'root';
    private $passwd = '';

    private $conexao;

    public function getConexao(){
        $this->conexao = null;
        try{
            $this->conexao = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->user,$this->passwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }catch(PDOException $e){
            die("Erro na conexão: ".$e->getMessage());
        }
        return $this->conexao;
    }
}