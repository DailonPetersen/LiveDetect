<?php
require_once 'classes/Conexao.php';
$conexao = new Conexao;


if ($conexao->connect()) {
    echo "Connect";
} else {
    echo $conexao->msgErro;
}

Class Usuario {

    private $pdo;
    public $msgErro = "";
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
        $query->bindValue(':u',$nomedeusuario);
        $query->bindValue(':p', $senha);
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

    public function getUsers(){
        global $pdo;
        $query = $pdo->prepare("SELECT email, nomedeusuario, id_usuario FROM usuarios");
        $query->execute();
        $users = $query->fetchAll(PDO::FETCH_ASSOC);
        return $users;
        
    }

    public function deleteByName($nomedeusuario){
        global $pdo;
        $query = $pdo->prepare("DELETE FROM usuarios WHERE nomedeusuario = :username ");
        $query->bindValue(':username', $nomedeusuario);
        $query->execute();
    }

    public function selectById($id_usuario){
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario = :id ");
        $query->bindValue(":id", $id_usuario);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function updateById($nomedeusuario, $email, $senha, $id_usuario){
        global $pdo;
        $query = $pdo->prepare("UPDATE usuarios SET nomedeusuario = :username, email = :email, senha = :pass WHERE id_usuario = $id_usuario ");
        $query->bindValue(":username", $nomedeusuario);
        $query->bindValue(":email", $email);
        $query->bindValue(":pass", $senha);
        $query->execute();
        $erro = $query->errorInfo();
    }
}

?>