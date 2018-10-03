<?php

class Categoria{
    public $id;
    public $nome;
    public $descricao;

    private $conexao;

    public function __construct($con){
        $this->conexao = $con;
    }
    
    public function create($values){
        try{
            $query='INSERT INTO categoria (nome,descricao) VALUES(?,?);';
            $post=$this->conexao->prepare($query);
            $post->bindParam(1,$values['nome'],PDO::PARAM_STR);
            $post->bindParam(2,$values['descricao'],PDO::PARAM_STR);
            $post->execute();
            if($post->rowCount()==0){
                die(json_encode(['error'=>'Parâmetros inválidos','method'=>'create']));
            }
            http_response_code(201);
        }catch(Exception $e){
            die(json_encode(['error'=>$e->getMessage(),'method'=>'create']));
        }
    }

    public function read($id=null){
        try{
            $query='SELECT * FROM categoria ';
            if(isset($id)){
                $get=$this->conexao->prepare($query. 'WHERE id=?');
                $get->bindParam(1,$id,PDO::PARAM_INT);
            }else{
                $get=$this->conexao->prepare($query);
            }
            $get->execute();
            if($get->rowCount()==0){
                die(json_encode(['error'=>'Nada foi encontrado','method'=>'read']));
            }
            if($get->rowCount()==1){
                $user=$get->fetchAll(PDO::FETCH_ASSOC);
                $this->nome=$user['nome'];
                $this->descricao=$user['descricao'];
            }
            die(json_encode($get->fetchAll(PDO::FETCH_ASSOC)));
        }catch(PDOException $e){
            die(json_encode(['error'=>$e->getMessage(),'method'=>'read']));
        }
    }

    public function update($values,$id){
        try{
            $query='UPDATE categoria SET ';
            if(isset($values['nome'])&&isset($values['descricao'])){
                $query.='nome=:nome,descricao=:descricao';
            }else if(isset($values['nome'])){
                $query.='nome=:nome';
            }else if(isset($values['descricao'])){
                $query.='descricao=:descricao';
            }else{
                die(json_encode(['error'=>'Favor inserir os valores','method'=>'update']));
            }

            $put=$this->conexao->prepare($query.' WHERE id=:id');
            if(isset($values['nome'])){
                $put->bindParam('nome',$values['nome'],PDO::PARAM_STR);
            }
            if(isset($values['descricao'])){
                $put->bindParam('descricao',$values['descricao'],PDO::PARAM_STR);
            }
            $put->bindParam('id',$id,PDO::PARAM_INT);
            $put->execute();
            if($put->rowCount()==0){
                die(json_encode(['error'=>'Parâmetros inválidos','method'=>'update']));
            }
        }catch(PDOException $e){
            die(json_encode(['error'=>$e->getMessage(),'method'=>'update']));
        }
    }
    public function delete($id){
        try{
            $id=intval($id);
            if(!isset($id)) die(json_encode(['error'=>'Informe o id corretamente','method'=>'delete']));
            $query='DELETE FROM categoria WHERE id=?';
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