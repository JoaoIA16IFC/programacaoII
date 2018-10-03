<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../config/Conexao.php';
require_once '../../models/Post.php';

if(!isset($_SERVER['PHP_AUTH_USER'])){
    header('WWW-Authenticate: Basic realm="Página Restrita"');
    header('HTTP/1.0 401 Unauthorized');
    die(json_encode(["error"=> 'Autenticação necessária']));
}
if($_SERVER['PHP_AUTH_USER']!= 'admin' || $_SERVER['PHP_AUTH_PW']!='admin') die(json_encode(["error"=> 'Erro ao autenticar']));

if($_SERVER['REQUEST_METHOD']!='DELETE') die(json_encode(["error"=> 'Método errado']));

$db = new Conexao();
$post = new Post($db->getConexao());
try{
    if(isset($_GET['id']) && $_GET['id']>0){
        $post->delete($_GET['id']);
    }else{
        die(json_encode(["error"=> 'Informe o ID corretamente']));
    }

}catch(PDOException $e){
    die("ERRO: ".$e->getMessage());
}