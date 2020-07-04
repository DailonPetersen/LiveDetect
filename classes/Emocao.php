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

    public function insertEmocao($emocoes, $id_pessoa) {
        global $pdo;
        $query = $pdo->prepare('INSERT INTO emocoes (emocoes, person_id) VALUES (:emotion, :personId)');
        $query->bindValue(":emotion", json_encode($emocoes));
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