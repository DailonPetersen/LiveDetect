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

//session_start();

if(isset($_POST['grupoAdetectar'])){
    $grupoAdetectar = $_POST['grupoAdetectar'];
    $intervalo = $_POST['intervalo'];
}


$msg = '';
if (isset($_POST['person_id'])) {

    $emocoes = $_POST['emocoes'];
    $id_pessoa = $_POST['person_id'];
    $group_id = $_POST['group_id'];

    if (!empty($emocoes) && !empty($id_pessoa) && !empty($group_id)) {

        $arrayEmocoes = json_decode($emocoes, true);
        var_dump($arrayEmocoes);

        if (!$emocao->insertEmocao(
            $emocoes['happiness'],
            $emocoes['anger'],
            $emocoes['contempt'],
            $emocoes['disgust'],
            $emocoes['neutral'],
            $emocoes['sadness'],
            $emocoes['surprise'],
            $id_pessoa,
            $group_id
        )) {
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script defer src="lib/face-api.min.js"></script>
    <script defer src="scripts/live_script.js"></script>

    <style>
        .form-panel{
            display: flex;
            flex-direction: row;
        }
        canvas{
            margin: 0;
            padding: 0;
            width: 480;
            height: 360;
            display: flex;
            justify-content: center;
            border: 2px solid white;
            align-items: center;
        }
        video{
            padding: 0;
            margin-right: 200px;
            border: 2px solid white;
        }
        textarea{
            margin: 0;
            padding: 0;
            padding: 10px;
            width: 100%;
            font-size: 15px;
        }
        button{
            position: absolute;
            width: 100;
            height: 50;
        }
    </style>

</head>

<body>
    <?php
    if (isset($msg)) {
        echo $msg;
    }
    ?>
    <div class="form-panel">
        <video id="video" width="480" height="360" autoplay muted></video>
        <br>
        <textarea id="detectresponse"></textarea>
        <input type="hidden" id="grupoAdetectar" name="grupoAdetectar" value="<?php echo @$grupoAdetectar ?>">
        <input type="hidden" id="intervalo" name="intervalo" value="<?php echo @$intervalo ?>">
        <button class="btn btn-primary" id="detecta">Detecta</button>
    </div>
    <div class="container-fluid">
        <input type="file" id="img">
        <button class="btn btn-primary" onclick="Detect()">Detecta</button>
    </div>

</body>

</html>