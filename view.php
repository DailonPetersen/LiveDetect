<?php 
    session_start();

    if (isset($_SESSION['nomedeusuario'])){
        $msg = $_SESSION['nomedeusuario'];
    } else {
        header("location: login.php");
    }
?>

<head>
    <meta charset="UTF-8">
    <title>Tela</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/areaadmin.css">

</head>

<body onload="carrega()" name="carrega">
    <div class="container-fluid" >
        <nav class="nav navbar navbar-expand-lg navbar-dark bg-dark">
            <h1 class="navbar-brand" style="font-size: 40px;">Teste Detecção</h1>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="#"> Apresentação <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="salvar.php">Área adminitrativa</a>
                    <a class="nav-item nav-link" href="livedetect.php">Área detecção</a>
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
    <div class="container-fluid" id="div_principal">
        <div class="row"> 
            <div class="col-sm-6">
                <!--<form method="post" action="script.js"> -->
                <h3>Criar Grupos</h3>
                <div class="form-group">
                    <label for="groupName">Nome do Grupo</label>
                    <input id="groupName" name="groupName" type="text" class="form-control" placeholder="Ex: Alunos">
                </div>

                <div class="form-group">
                    <label for="groupData">Informações sobre o Grupo</label>
                    <input id="groupData" name="groupData" type="text" class="form-control" placeholder="Ex: Grupo de alunos">
                </div>
                <button id="btnGroup" type="submit" onclick="createGroup()" class="btn btn-danger">Criar Grupo</button>
                <!--    </form>-->
            </div>
            <div class="col-sm-6">
                <!--<form method="post" action="script.js"> -->
                <h3>Criar Pessoas</h3>
                <div class="form-group">
                    <label for="personName">Nome da Pessoa</label>
                    <input id="personName" name="personName" type="text" class="form-control" placeholder="Ex: Dailon">
                </div>

                <div class="form-group">
                    <label for="personData">Informações sobre a pessoa</label>
                    <input id="personData" name="personData" type="text" class="form-control" placeholder="Ex: sei lá">
                </div>
                <div class="form-group">
                    <label for="groupId">Group ID</label>
                    <input id="groupId" name="groupId" type="text" class="form-control">
                </div>
                <button id="btnPerson" type="submit" onclick="createPerson()" class="btn btn-danger">Criar Pessoa</button>
                <!--    </form>-->
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-6">
                <div class="form-group">
                    <h3>Detecção</h3>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="inputToDetect" id="inputToDetect" multiple>
                            <label class="custom-file-label" for="inputToDetect">Imagem para detectar</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-danger" id="btnDetec" name="btnDetec" onclick="Detect()">Detecta</button>
                        </div>
                    </div>
                    <textarea id="detectResponse" class="form-control" aria-label="With textarea" style="height:190px;">

                    </textarea>
                </div>
            </div>
            <div class="col-sm-6">
                <h3>Adicione as faces</h3>
                <form id="salva_imagens" name="salva_imagens" action="salvar.php" method="POST" enctype="multipart/form-data">
                    <label>Após criar a pessoa, escolha as imagens para treinar o sistema</label>
                    <div class="form-group">
                        <label>ID da pessoa</label>
                        <input id="personId" name="personId" type="text" class="form-control" placeholder="...">
                    </div>
                    <div class="form-group">
                        <label>ID do Groupo</label>
                        <input id="groupIdImage" name="groupIdImage" type="text" class="form-control" placeholder="...">
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="inputFiles" id="inputFiles" multiple>
                                <label class="custom-file-label" for="inputFiles">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-danger" id="btnImages" name="btnImages">Adicionar Imagens</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <hr>

        <div id="imagesSelected" class="container-fluid">


            <img id="img">

        </div>

        <script src="scripts/script.js"></script>
</body>

</html>