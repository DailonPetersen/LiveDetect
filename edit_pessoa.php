<?php
require_once 'funcoes_upload.php';
require_once 'classes/Pessoa.php';
require_once 'classes/Grupo.php';
$pessoa = new Pessoa;
$grupo = new Grupo;

if (isset($_GET['edit_person_id'])) {
    $person_id = addslashes($_GET['edit_person_id']);
    $dados = $pessoa->selectByPersonId($person_id);
}

if (@$_POST['enviar']) {
    //funcao vem do funcoes_upload.php
    publicarArquivo($_FILES['inputImagem'], $_POST['personId']);

}   


?>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edicao da pessoa</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
</head>

<script>
    function NovoCadastro(el) {
        var display = document.getElementById(el).style.display;
        if (display == "none") {
            document.getElementById(el).style.display = 'block';
            window.location.href = '#form-cadastro';
        }
    }

    function CancelarCadastro(el) {
        var display = document.getElementById(el).style.display;
        if (display == "block") {
            document.getElementById(el).style.display = 'none';
            document.getElementById('form-cadastro').reset();
        }
    }
</script>

<body>
    <div class="form-panel" style="display: block;" id="div-cadastro">
        <h4 class="mb"><i class="fa fa-angle-right"></i> Editar Pessoa</h4>
        <h5>Para concluir o cadastro, adicione pelo menos duas fotos desta pessoa.</h5>
        <form class="form-horizontal style-form" method="post" id="form-cadastro">
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Nome</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($dados)) {
                                                                                                echo $dados['nome'];
                                                                                            } ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Informações Adicionais</label>
                <div class="col-sm-10">
                    <textarea type="text" class="form-control" name="userData" id="userData"><?php if (isset($dados)) {
                                                                                                    echo $dados['info'];
                                                                                                } ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Grupo</label>
                <div class="col-sm-10">
                    <select class="form-control" name="id_grupo" id="id_grupo">
                        <?php if (!isset($dados)) {
                            $grupos = $grupo->getGroups();
                            if (count($grupos) > 0) {
                                for ($i = 0; $i < count($grupos); $i++) { ?>
                                    <option><?php echo $grupos[$i]['id_grupo'] ?></option>
                            <?php       }
                            }
                        } else { ?>
                            <option>O grupo não pode ser alterado!</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Person ID</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="personId" id="personId" value="<?php if (isset($dados)) {
                                                                                                        echo 'O personID não pode ser alterado!';
                                                                                                    } ?>">
                </div>
            </div>

            <div style="background-color: #000;">

            </div>

            <input type="submit" class="btn btn-primary" name='salvar' onclick="salvarPessoa(this.value)" value='<?php if (isset($dados)) {
                                                                                                                        echo "Atualizar";
                                                                                                                    } else {
                                                                                                                        echo "Cadastrar";
                                                                                                                    } ?>'>
            <button type="button" class="btn btn-danger" onclick="CancelarCadastro('div-cadastro')">Fechar</button>
        </form>
        <hr>
        <?php
        if (isset($msg)) {
        ?>
            <p class="msg" style="color: red;"><?php echo $msg ?></p>
        <?php
        }
        ?>
    </div>

    <div class="form-panel">
        <div class="form-horizontal style-form" method="post" id="form-imagem" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Adicione uma imagem do rosto da pessoa</label>
                <div class="col-sm-10">
                    <input type="hidden" name="MAX_FILE_SIZE" value="6000000">
                    <input type="file" class="form-control" name="inputImagem" id="inputImagem" multiple>
                    <input class="btn btn-success" type="submit" id="enviar" name="enviar" value="Enviar" onclick="AddFaceToPerson()">
                </div>
            </div>
            <?php
            if (isset($msg)) {
            ?>
                <p class="msg" style="color: red;"><?php echo $msg ?></p>
            <?php
            }
            ?>
        </div>
    </div>
    <script src="scripts/pessoa_script.js"></script>
</body>

</html>