<?php

class Post{
    public $id;
    public $titulo;
    public $texto;
    public $categoria;
    public $autor;
    public $dt_criacao;

    private $conexao;

    public function __construct($con){
        $this->conexao = $con;
    }
    
    public function create($values){
        try{
            $error=[];
            if(!isset($values['titulo'])||$values['titulo']=='') array_push($error,'Título inválido');
            if(!isset($values['texto'])||$values['texto']=='') array_push($error,'Texto inválido');
            if(!isset($values['autor'])||$values['autor']=='') array_push($error,'Autor inválido');
            if(!isset($values['id_categoria'])||intval($values['id_categoria']<=0)) array_push($error,'Categoria inválida');
            
            if(sizeof($error)>0) die(json_encode(['error'=>$error,'method'=>'create']));
            
            $query='INSERT INTO post (titulo,texto,autor,id_categoria) VALUES(?,?,?,?);';
            $post=$this->conexao->prepare($query);
            $post->bindParam(1,$values['titulo'],PDO::PARAM_STR);
            $post->bindParam(2,$values['texto'],PDO::PARAM_STR);
            $post->bindParam(3,$values['autor'],PDO::PARAM_STR);
            $post->bindParam(4,$values['id_categoria'],PDO::PARAM_INT);
            $post->execute();
            if($post->rowCount()==0){
                http_response_code(201);
                die(json_encode(['error'=>'Parâmetros inválidos','method'=>'create']));
            }
        }catch(Exception $e){
            die(json_encode(['error'=>$e->getMessage(),'method'=>'create']));
        }
    }

    public function read($id=null){
        try{
            $query='SELECT * FROM post ';
            if(isset($id)){
                if(isset($id['post'])){
                    $id=$id['post'];
                    $query.='WHERE id=?';
                }else{
                    $id=$id['cat'];
                    $query.='WHERE id_categoria=?';
                }
                $get=$this->conexao->prepare($query);
                $get->bindParam(1,$id,PDO::PARAM_INT);
            }else{
                $get=$this->conexao->prepare($query);
            }
            $get->execute();
            if($get->rowCount()==0){
                die(json_encode(['error'=>'Nada foi encontrado','method'=>'read']));
            }
            die(json_encode($get->fetchAll(PDO::FETCH_ASSOC)));
        }catch(PDOException $e){
            die(json_encode(['error'=>$e->getMessage(),'method'=>'read']));
        }
    }

    public function update($values,$id){
        try{
            $id=intval($id);
            $error=[];
            if(!isset($id)) array_push($error,'Informe o ID corretamente');
            if(!isset($values['titulo'])||$values['titulo']=='') array_push($error,'Título inválido');
            if(!isset($values['texto'])||$values['texto']=='') array_push($error,'Texto inválido');
            if(!isset($values['autor'])||$values['autor']=='') array_push($error,'Autor inválido');
            if(!isset($values['id_categoria'])||intval($values['id_categoria']<=0)) array_push($error,'Categoria inválida');
            
            if(sizeof($error)>0) die(json_encode(['error'=>$error,'method'=>'update']));
            
            $query="UPDATE post SET titulo=?,texto=?,autor=?,id_categoria=? WHERE id=?;";
            $put=$this->conexao->prepare($query);
            $put->bindParam(1,$values['titulo'],PDO::PARAM_STR);
            $put->bindParam(2,$values['texto'],PDO::PARAM_STR);
            $put->bindParam(3,$values['autor'],PDO::PARAM_STR);
            $put->bindParam(4,$values['id_categoria'],PDO::PARAM_INT);
            $put->bindParam(5,$id,PDO::PARAM_INT);
            $put->execute();
            if($put->rowCount()==0){
                die(json_encode(['error'=>'Impossível atualizar','method'=>'update']));
            }
        }catch(PDOException $e){
            die(json_encode(['error'=>$e->getMessage(),'method'=>'update']));
        }
    }
    public function delete($id){
        try{
            $id=intval($id);
            if(!isset($id)) die(json_encode(['error'=>'Informe o ID corretamente','method'=>'delete']));
            $query='DELETE FROM post WHERE id=?';
            $delete=$this->conexao->prepare($query);
            $delete->bindParam(1,$id,PDO::PARAM_INT);
            $delete->execute();
            if($delete->rowCount()==0){
                die(json_encode(['error'=>'Nada foi encontrado','method'=>'delete']));
            }
        }catch(PDOException $e){
            die(json_encode(['error'=>$e->getMessage(),'method'=>'delete']));
        }
    }
}