<?php
require_once 'classes/Conexao.php';
$conexao = new Conexao;


if ($conexao->connect()) {
    echo "Connect";
} else {
    echo $conexao->msgErro;
}

Class Emocao {

    private $pdo;

    public function insertEmocao($emocoes, $faceId, $id_pessoa) {
        global $pdo;
        
        $query = $pdo->prepare('INSERT INTO emocoes (emocoes, faceId, id_pessoa) VALUES (:emotion, :faceId, :personId)');
        $query->bindValue(":emotion", $emocoes);
        $query->bindValue(":faceId",$faceId);
        $query->bindValue(":personId", $id_pessoa);
        try {
            $query->execute();
        } catch (PDOException $e){
            $msgErro = $e->getMessage();
            var_dump($msgErro);
        }
    }
}



?>