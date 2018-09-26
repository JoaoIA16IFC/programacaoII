<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../config/Conexao.php';
require_once '../../models/Categoria.php';

if($_SERVER['REQUEST_METHOD']!='DELETE') die('ERRO: Método errado');

$db = new Conexao();
$cat = new Categoria($db->getConexao());
try{
    if(isset($_GET['id']) && $_GET['id']>0){
        $cat->delete($_GET['id']);
    }else{
        die('Informe o id corretamente');
    }

}catch(PDOException $e){
    die("ERRO: ".$e->getMessage());
}

