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
            if(!isset($values['titulo'])||$values['titulo']=='') die(json_encode(['error'=>'Título inválido','method'=>'create']));
            if(!isset($values['texto'])||$values['texto']=='') die(json_encode(['error'=>'Texto inválido','method'=>'create']));
            if(!isset($values['autor'])||$values['autor']=='') die(json_encode(['error'=>'Autor inválido','method'=>'create']));
            if(!isset($values['id_categoria'])||intval($values['id_categoria']<=0)) die(json_encode(['error'=>'Categoria inválida','method'=>'create']));
            
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
                $get=$this->conexao->prepare($query. 'WHERE id=?');
                $get->bindParam(1,$id,PDO::PARAM_INT);
            }else{
                $get=$this->conexao->prepare($query);
            }
            $get->execute();
            if($get->rowCount()==0){
                die(json_encode(['error'=>'Nada foi encontrado','method'=>'read']));
            }
            echo 'mane';
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