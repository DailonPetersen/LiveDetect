<?php 
    $conexao =  new PDO("mysql:host=localhost;dbname=livedetect", "dailon", "1234");

    $query = $conexao->prepare("SELECT * FROM imagens ");
    $query->bindParam(1, $id);
    $query->execute();
    while ( $row = $query->fetch() ){
        header('Content-type:'.$row['mime']);
        echo "<li>".$row['imagem']."<li>";
    };
    
?>