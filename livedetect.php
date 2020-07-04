<?php

require_once 'classes/Conexao.php';
require_once 'classes/Emocao.php';
$conexao = new Conexao;
$emocao = new Emocao;

if ($conexao->connect()) {
    echo "Connect";
} else {
    echo $conexao->msgErro;
}

session_start();

if (isset($_SESSION['nomedeusuario'])){
    $msg = $_SESSION['nomedeusuario'];
} else {
    header("location: login.php");
}

    $msg = '';
    if ( isset($_POST['id_pessoa']) ){

        $emocoes = $_POST['emocoes'];
        $id_pessoa = $_POST['id_pessoa'];
        
        if( !empty($emocoes) && !empty($id_pessoa) ){
            if ( $emocao->insertEmocao($emocoes, $id_pessoa) ) {
                $msg = "Inseriu emocao";
            } else {
                $msg = "Erro!";
            }
        }

    }

?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script defer src="lib/face-api.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script defer src="scripts/live_script.js"></script>
    <style>
        body{
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        canvas{
            position    : absolute;
        }
    </style>
</head>
<body>
            <?php
            if (isset($msg)) {
                echo $msg;
            }
            ?>
    <video id="video" width="720" height="480" autoplay muted></video>
    <button id="detecta">Detecta</button>
</body>
</html>