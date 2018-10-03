<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../config/Conexao.php';
require_once '../../models/Categoria.php';

if(!isset($_SERVER['PHP_AUTH_USER'])){
    header('WWW-Authenticate: Basic realm="Página Restrita"');
    header('HTTP/1.0 401 Unauthorized');
    die(json_encode(["mensagem"=> 'Autenticação necessária']));
}
if($_SERVER['PHP_AUTH_USER']!= 'admin' || $_SERVER['PHP_AUTH_PW']!='admin') die(json_encode(["mensagem"=> 'Erro ao autenticar']));
if($_SERVER['REQUEST_METHOD']!='PUT') die(json_encode(["error"=> 'Método errado']));

$db = new Conexao();
$cat = new Categoria($db->getConexao());

try{
    $values = json_decode(file_get_contents('php://input'),true);
    if(!isset($values)||$values=="")  die(json_encode(["error"=> 'Valores incorretos']));
    if(!isset($_GET['id']) || $_GET['id']<1) die(json_encode(["error"=> 'ID incorreto']));
    $cat->update($values,$_GET['id']);
}catch(PDOException $e){
    die("ERRO: ".$e->getMessage());
}
