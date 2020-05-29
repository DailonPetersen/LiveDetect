<!DOCTYPE html>

<?php
    $conexao =  new PDO("mysql:host=localhost;dbname=faces", "dailon", "1234");

    if( isset($_POST["btn"]) ) {
        $personID = $_POST["personId"];
        $name = $_FILES["myfile"]["name"];
        $type = $_FILES["myfile"]["type"];
        $data = file_get_contents($_FILES["myfile"]["tmp_name"]);

        $stmt = $conexao->prepare("INSERT into imagens value('',?,?,?)");
        $stmt->bindParam(1,$data);
        $stmt->bindParam(2,$personID);
        $stmt->bindParam(3,$type);
        $stmt->execute();
    }
?>

<html>
    
    <body>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="personId">
            <input type="file" name="myfile">
            <button name="btn">Upload</button>

        </form>
    </body>

</html>

