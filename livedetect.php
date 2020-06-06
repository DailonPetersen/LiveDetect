<?php 
    session_start();

    if (isset($_SESSION['nomedeusuario'])){
        $msg = $_SESSION['nomedeusuario'];
    } else {
        header("location: login.php");
    }
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Video Live</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script defer src="./lib/face-api.min.js"></script>
    <script defer src="./scripts/script.js"></script>
    <link rel="stylesheet" href="css/livedetect.css">
</head>
<body>
    
    <div class="container-fluid" >
        <nav class="nav navbar navbar-expand-lg navbar-dark bg-dark">
            <h1 class="navbar-brand" style="font-size: 40px;">Teste Detecção</h1>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="#"> Apresentação <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="salvar.php">Área adminitrativa</a>
                    <a class="nav-item nav-link" href="videolive.html">Área detecção</a>
                    <a class="nav-item nav-link disabled" href="#">Disabled</a>
                </div>
            </div>
            <span class="navbar-text">
                Trabalho de conclusao do curso de ADS - FTEC
                <?php 
                    if (isset($_SESSION['nomedeusuario'])){
                ?>
                    <a href="#"><?php  echo $msg ?></a>        
                <?php 
                    }
                ?>
                <a href="sair.php">Sair</a>
            </span>
        </nav>
    </div>

    <main class="row">                
        <div class="col-sm-6 video">
            <video id="video" width="1280" height="720" autoplay muted class="embed-responsive-item">
            </video>
        </div>
        <div class="col-sm-6">
            <p>Algumas coisas</p>
        </div>
    </main>
    <canvas id="canvas" style="display: none;"></canvas>
    <button onclick="CaptureImage()" class="btn btn-outline-primary">Capture</button>
</body>
</html>