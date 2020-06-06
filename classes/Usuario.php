<?php

Class Usuario {

    private $pdo;
    public $msgErro = "";
    public function connect(){
        global $pdo;
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=livedetect", "dailon", "1234");
        }catch (PDOException $e){
            $msgErro = $e->getMessage();
        }

    }
    public function create($email, $nomedeusuario, $senha){

        global $pdo;
        $query = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE nomedeusuario = :username");
        $query->bindValue(":username", $nomedeusuario);
        $query->execute();
        if($query->rowCount() > 0){
            return false;
        } else {
            $query = $pdo->prepare("INSERT INTO usuarios (nomedeusuario, senha, email) VALUES (:n, :s, :e)");
            $query->bindValue(":n", $nomedeusuario);
            $query->bindValue(":s", $senha);
            $query->bindValue(":e", $email);
            $query->execute();
            return true;
        }
    }
    
    public function loggin($nomedeusuario, $senha){
        global $pdo;
        $query = $pdo->prepare("SELECT nomedeusuario FROM usuarios WHERE nomedeusuario = :u AND senha = :p");
        $query->bindParam(':u',$nomedeusuario, PDO::PARAM_STR);
        $query->bindParam(':p',$senha, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0){
            $dado = $query->fetch();
            session_start();
            $_SESSION['nomedeusuario'] = $dado['nomedeusuario'];
            return true;
        } else {
            return false;
        }
    }

}



?>