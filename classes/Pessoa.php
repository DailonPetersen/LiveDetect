<?php
require_once 'classes/Conexao.php';
$conexao = new Conexao;

if ($conexao->connect()) {
    echo "Connect";
} else {
    echo $conexao->msgErro;
}

Class Pessoa {

    private $pdo;
    public $msgErro = "";
    public function create($nome, $info, $id_grupo, $person_id){

        global $pdo;
        $query = $pdo->prepare("SELECT id_pessoa FROM pessoas WHERE person_id = :person_id");
        $query->bindValue(":person_id", $person_id);
        $query->execute();
        if($query->rowCount() > 0){
            return false;
        } else {
            $query = $pdo->prepare("INSERT INTO pessoas (nome, info, id_grupo, person_id) VALUES (:nome, :info, :id_grupo, :personid)");
            $query->bindValue(":nome", $nome);
            $query->bindValue(":info",$info);
            $query->bindValue(":id_grupo", $id_grupo);
            $query->bindValue(":personid", $person_id);
            try {
                $query->execute(); 
                return true;
            } catch (Exception $e){
                $msgErro = $e;
                return $msgErro;
            }
            

        }
    }
    

    public function getPessoas(){
        global $pdo;
        $query = $pdo->prepare("SELECT person_id, nome, info, id_grupo FROM pessoas");
        $query->execute();
        $pessoas = $query->fetchAll(PDO::FETCH_ASSOC);
        return $pessoas;
        
    }

    public function deleteByPersonId($person_id){
        global $pdo;
        $query = $pdo->prepare("DELETE FROM pessoas WHERE person_id = :person_id ");
        $query->bindValue(':person_id', $person_id);
        $query->execute();
    }

    public function selectByPersonId($person_id){
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM pessoas WHERE person_id = :person_id ");
        $query->bindValue(":person_id", $person_id);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function updateByPersonId($person_id, $nome, $info){
        global $pdo;
        $query = $pdo->prepare("UPDATE pessoas SET nome = :nome, info = :info WHERE person_id = :person_id ");
        $query->bindValue(":nome", $nome);
        $query->bindValue(":info", $info);
        $query->bindValue(":person_id", $person_id);
        $query->execute();
        $erro = $query->errorInfo();
    }

}