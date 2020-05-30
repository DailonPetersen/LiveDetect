<?php 

    $conexao =  new PDO("mysql:host=localhost;dbname=faces", "dailon", "1234");

    $id = isset($_GET['id'])? $_GET['id'] : "";
    $stat = $conexao->prepare("SELECT * FROM imagens WHERE cod_imagem=?");
    $stat->bindParam(1, $id);
    $stat->execute();
    $row = $stat->fetch();
    header('Content-type:'.$row['mime']);
    echo $row['imagem'];