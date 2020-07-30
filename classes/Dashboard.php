<?php
require_once 'classes/Conexao.php';
$conexao = new Conexao;

if ($conexao->connect()) {
    echo "Connect";
} else {
    echo $conexao->msgErro;
}

Class Dashboard {

    private $pdo;

    public function getAlunosPorGrupo($id_grupo){
        global $pdo;

        $query = $pdo->prepare('SELECT * FROM pessoas WHERE id_grupo = :id_grupo');
        $query->bindValue(':id_grupo', $id_grupo);
        try {
            $query->execute();
            $alunos = $query->fetchAll(PDO::FETCH_ASSOC);
            return $alunos;
        } catch (PDOException $e){
            $msgErro = $e->getMessage();
            var_dump($msgErro);
        }
    }

    public function getEmocoesPorPessoa($personId){
        global $pdo;

        $query = $pdo->prepare('SELECT data, person_id, anger, contempt, disgust, happiness, neutral, sadness, surprise FROM emocoes WHERE person_id = :personid');
        $query->bindValue(':personid', $personId);
        $query->execute();
        $emocoes = $query->fetchAll(PDO::FETCH_ASSOC);
        return $emocoes;
    }

    public function getEmocoesPorGroup($group_id){
        global $pdo;

        $query = $pdo->prepare('SELECT emocoes, data FROM emocoes WHERE group_id = :group_id');
        $query->bindValue(':group_id', $group_id);
        $query->execute();
        $emocoes = $query->fetchAll(PDO::FETCH_ASSOC);
        return $emocoes;
    }



}



?>