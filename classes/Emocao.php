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

    public function insertEmocao($happiness, $anger, $contempt, $disgust, $neutral,
    $sadness, $surprise, $id_pessoa, $group_id) {
        global $pdo;
        $query = $pdo->prepare('INSERT INTO emocoes (anger, contempt, disgust, happiness, neutral, sadness, surprise, person_id, group_id) 
                                VALUES (:anger, :contempt, :disgust, :happiness, :neutral, :sadness, :surprise, :personId, :group_id)');
        $query->bindValue(":anger", $anger);
        $query->bindValue(":contempt", $contempt);
        $query->bindValue(":disgust", $disgust);
        $query->bindValue(":happiness", $happiness);
        $query->bindValue(":neutral", $neutral);
        $query->bindValue(":sadness", $sadness);
        $query->bindValue(":surprise", $surprise);
        $query->bindValue(":personId", $id_pessoa);
        $query->bindValue(":group_id", $group_id);
        try {
            $query->execute();
        } catch (PDOException $e){
            $msgErro = $e->getMessage();
            var_dump($msgErro);
        }
    }
}

?>
