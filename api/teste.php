<?php
header('Content-Type: application/json; charset=utf-8');
include_once '../config/Conexao.php';
include_once '../models/Categoria.php';
$db = new Conexao();

$cat = new Categoria($db->getConexao());
// echo("GET:");
// print_r($cat->read());

// echo("POST:");
// $user = file_get_contents('php://input');

echo("PUT:\n");
$values = json_decode(file_get_contents('php://input'),true);
$cat->update($values,$_GET['id']);