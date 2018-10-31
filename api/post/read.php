<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
require_once '../../config/Conexao.php';
require_once '../../models/Post.php';

if($_SERVER['REQUEST_METHOD']!='GET') die(json_encode(["error"=> 'Método errado']));
$db = new Conexao();
$post = new Post($db->getConexao());
try{
    if(isset($_GET['idpost']) && $_GET['idpost']>0){
        $post->read(['post'=>$_GET['idpost']]);
    }else if(isset($_GET['idcat']) && $_GET['idcat']>0){
        $post->read(['cat'=>$_GET['idcat']]);
    }else{
        $post->read();
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