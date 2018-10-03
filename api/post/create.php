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

if($_SERVER['REQUEST_METHOD']!='POST') die(json_encode(["error"=> 'Método errado']));

$db = new Conexao();
$post = new Post($db->getConexao());

$values = json_decode(file_get_contents('php://input'),true);
if(!isset($values)||$values=="") die(json_encode(["error"=> 'Dados incorretos']));
$post->create($values);
