<?php
header('Content-Type: application/json; charset=utf-8');

require_once '../../config/Conexao.php';
require_once '../../models/Categoria.php';
if(!isset($_SERVER['PHP_AUTH_USER'])){
    header('WWW-Authenticate: Basic realm="Página Restrita"');
    header('HTTP/1.0 401 Unauthorized');
    die(json_encode(["mensagem"=> 'Autenticação necessária']));
}elseif($_SERVER['PHP_AUTH_USER']!= 'admin'
        || $_SERVER['PHP_AUTH_PW']!='admin'){
            die(json_encode(["mensagem"=> 'Erro ao autenticar']));
}
if($_SERVER['REQUEST_METHOD']!='GET') die('ERRO: Método errado');
$db = new Conexao();
$cat = new Categoria($db->getConexao());
try{
    if(isset($_GET['id']) && $_GET['id']>0){
        $cat->read($_GET['id']);
    }else{
        $cat->read();
    }

}catch(PDOException $e){
    die("ERRO: ".$e->getMessage());
}


// try{
//     $query='SELECT * FROM categoria ';

//     if(isset($_GET['id'])){
//         $get=$this->conexao->prepare($query. 'WHERE idcategoria=?');
//         $get->bindParam(1,$_GET['id'],PDO::PARAM_INT);
//     }else{
//         $get=$this->conexao->prepare($query);
//     }
//     $get->execute();
//     print_r(($get->fetchAll(PDO::FETCH_ASSOC)));
//     //return json_encode($get->fetchAll(PDO::FETCH_ASSOC));
// }catch(PDOException $e){
//     die("Erro ao ler: ".$e->getMessage());
// }