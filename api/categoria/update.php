<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../config/Conexao.php';
require_once '../../models/Categoria.php';

if($_SERVER['REQUEST_METHOD']!='PUT') die('ERRO: Método errado');
$db = new Conexao();
$cat = new Categoria($db->getConexao());
try{
    $values = json_decode(file_get_contents('php://input'),true);
    if(!isset($values)||$values=="") die("ERRO: informe os valores do usuário corretamente");
    if(isset($_GET['id']) && $_GET['id']>0){
        $cat->update($values,$_GET['id']);
    }else{
        die('ERRO: informe o id corretamente');
    }
}catch(PDOException $e){
    die("ERRO: ".$e->getMessage());
}
