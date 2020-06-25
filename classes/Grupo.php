<?php
require_once 'classes/Conexao.php';
$conexao = new Conexao;


if ($conexao->connect()) {
    echo "Connect";
} else {
    echo $conexao->msgErro;
}

Class Grupo {

    private $pdo;

    public function create($id_grupo, $nomedogrupo, $infogrupo){

        global $pdo;
        $query = $pdo->prepare("SELECT nome_grupo FROM grupos WHERE nome_grupo = :groupname");
        $query->bindValue(":groupname", $nomedogrupo);
        $query->execute();
        if($query->rowCount() > 0){
            return false;
        } else {
            $query = $pdo->prepare("INSERT INTO grupos (nome_grupo, info_grupo, id_grupo) VALUES (:nome, :info, :id)");
            $query->bindValue(":nome", $nomedogrupo);
            $query->bindValue(":info",$infogrupo);
            $query->bindValue(":id", $id_grupo);
            $query->execute();
            return true;
        }
    }

    public function getGroups(){
        global $pdo;

        $query = $pdo->prepare("SELECT id_grupo, nome_grupo, info_grupo FROM grupos");
        $query->execute();
        $grupos = $query->fetchAll(PDO::FETCH_ASSOC);
        return $grupos;
    }

    public function deleteById($id_grupo){
        global $pdo;
        $query = $pdo->prepare("DELETE FROM grupos WHERE id_grupo = :id ");
        $query->bindValue(':id', $id_grupo);
        $query->execute();
    }

    public function selectById($id_grupo){
        global $pdo;
        $query = $pdo->prepare("SELECT * FROM grupos WHERE id_grupo = :id ");
        $query->bindValue(":id", $id_grupo);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function updateById($id_grupo, $nomedogrupo, $infodogrupo){
        global $pdo;
        $query = $pdo->prepare("UPDATE grupos SET nome_grupo = :nome, info_grupo = :info WHERE id_grupo = $id_grupo ");
        $query->bindValue(":nome", $nomedogrupo);
        $query->bindValue(":info", $infodogrupo);
        $query->execute();
        $erro = $query->errorInfo();
    }


}

?>