<!DOCTYPE html>

<?php
$conexao =  new PDO("mysql:host=localhost;dbname=faces", "dailon", "1234");

if (isset($_POST["btnImages"])) {
    $personID = $_POST["personId"];
    $name = $_FILES["inputFiles"]["name"];
    $type = $_FILES["inputFiles"]["type"];
    $data = file_get_contents($_FILES["inputFiles"]["tmp_name"]);

    //header('Content-type:'.$type);

    $query = $conexao->prepare("INSERT into imagens value('',?,?,?,?)");
    $query->bindParam(1, $data);
    $query->bindParam(2, $name);
    $query->bindParam(3, $personID);
    $query->bindParam(4, $type);
    $query->execute();
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body onload="carrega()" name="carrega">

    <h1> Teste Detecção </h1>

    <span> Trabalho de conclusao do curso de ADS - FTEC</span>
    <hr>

    <div class="container-fluid">
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
                <button id="btnGroup" type="submit" onclick="createGroup()" class="btn btn-success">Criar Grupo</button>
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
                <button id="btnPerson" type="submit" onclick="createPerson()" class="btn btn-success">Criar Pessoa</button>
                <!--    </form>-->
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-sm-6">
                <div class="form-group">
                    <h3>Identificar</h3>
                    <input type="text" name="group_id" placeholder="grupo ID" id="group_id">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="img_Indentify" id="img_Indentify" multiple>
                            <label class="custom-file-label" for="inputFiles">Imagem pra identificar</label>
                        </div>
                    </div>
                    <button id="btnIndentify" class="btn btn-success" onclick="Identify()">Identificar</button>
                </div>
                <textarea id="indentifyResponse" class="form-control" aria-label="With textarea">

                </textarea>
            </div>
            <div class="col-sm-6">
                <h4>Adicione as faces</h4>
                <form id="salva_imagens" name="salva_imagens" method="POST" enctype="multipart/form-data">
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
                                <button class="btn btn-success" id="btnImages" name="btnImages">Adicionar Imagens</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <h3>Detecção</h3>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="inputToDetect" id="inputToDetect" multiple>
                    <label class="custom-file-label" for="inputToDetect">Imagem para detectar</label>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-success" id="btnImages" name="btnImages" onclick="Detect()">Detecta</button>
                </div>
            </div>
            <textarea id="detectResponse" class="form-control" aria-label="With textarea" style="height: 300px;">

            </textarea>
        </div>
    </div>


    <hr>

    <div id="imagesSelected" class="container-fluid">


        <?php
            $query = $conexao->prepare("SELECT * FROM imagens ");
            $query->bindParam(1, $id);
            $query->execute();
            while ( $row = $query->fetch() ){
                //header('Content-type:'.$row['mime']);
                echo "<li><a href='view.php?id=".$row['imagem']."'>".$row['nome']."</a></li>";
            };
        
        ?>

        <img id="img">

    </div>

    <script src="script.js"></script>
</body>

</html>