<!DOCTYPE html>

<?php
$conexao =  new PDO("mysql:host=localhost:3306;dbname=livedetect", "dailon", "1234");

if (isset($_POST["btnImages"])) {
    $faceId = $_POST[""];
    $personID = $_POST["personId"];
    $name = $_FILES["inputFiles"]["name"];
    $type = $_FILES["inputFiles"]["type"];
    $data = file_get_contents($_FILES["inputFiles"]["tmp_name"]);

    //header('Content-type:'.$type);

    $query = $conexao->prepare("INSERT into faces (faceId, imagem, id_pessoa, mime, nome_imagem) value(:fId,:d,:pId,:t,:n)");
    $query->bindParam(":fId", $faceId);
    $query->bindParam(":d", $data);
    $query->bindParam(":pId", $personID);
    $query->bindParam(":t", $type);
    $query->bindParam(":n", $name);
    $query->execute();
}

?>
