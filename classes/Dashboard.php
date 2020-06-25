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

    public function getEmocaoPorAluno($id_pessoa) {
        global $pdo;
        
        $query = $pdo->prepare('SELECT * FROM emocoes WHERE id_pessoa = :id_pessoa');
        $query->bindValue(":id_pessoa", $id_pessoa);
        try {
            $query->execute();
        } catch (PDOException $e){
            $msgErro = $e->getMessage();
            var_dump($msgErro);
        }
    }

    public function getAlunosPorGrupo($id_grupo){
        global $pdo;

        $query = $pdo->prepare('SELECT * FROM pessoas WHERE id_grupo = :id_grupo');
        $query->bindValue(':id_grupo', $id_grupo);
        try {
            $query->execute();
        } catch (PDOException $e){
            $msgErro = $e->getMessage();
            var_dump($msgErro);
        }
    }

    public function getEmocoesPorPessoa($personId){
        global $pdo;

        $query = $pdo->prepare('SELECT emocoes FROM emocoes WHERE person_id = :personid');
        $query->bindValue(':personid', $personId);
        $query->execute();
        $emocao = $query->fetch(PDO::FETCH_ASSOC);
        return $emocao;
    }


}



?>