<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../../config/Conexao.php';
require_once '../../models/Categoria.php';

if($_SERVER['REQUEST_METHOD']!='POST') die('ERRO: Método errado');
$db = new Conexao();
$cat = new Categoria($db->getConexao());
$values = json_decode(file_get_contents('php://input'),true);
if(!isset($values)||$values=="") die("ERRO: informe os valores do usuário corretamente");
$cat->create($values);
