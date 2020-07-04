<?php
require_once 'classes/Pessoa.php';
require_once 'classes/Grupo.php';
$pessoa = new Pessoa;
$grupo = new Grupo;


if(isset($_POST['personId'])){

    $nome = addslashes($_POST['name']);
    $info = addslashes($_POST['userData']);
    $id_grupo = addslashes($_POST['id_grupo']);
    $person_id = addslashes($_POST['personId']);
    
    if ( !isset($_GET['edit_person_id']) ){
        
        if (!empty($nome) && !empty($info) && !empty($id_grupo) && !empty($person_id)) {
            if ( !$pessoa->create($nome, $info, $id_grupo, $person_id) ) {
                $msg = "Pessoa cadastrada com sucesso!";
            } else {
                $msg = "Não foi";
            }
        } else {
            $msg = "Preencha todos os campos!";
        }
    } else {
        $edit_person_id = $_GET['edit_person_id'];
        $pessoa->updateByPersonId($edit_person_id, $nome, $info);
    }


}

if(isset($_GET['delete_person_id'])){
    $person_id = addslashes($_GET['delete_person_id']); 
    $pessoa->deleteByPersonId($person_id);
}

if(isset($_GET['edit_person_id'])){
    $person_id = addslashes($_GET['edit_person_id']);
    $dados = $pessoa->selectByPersonId($person_id);
}


?>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
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
    <div class="form-panel">
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <table class="table table-striped table-advance table-hover">
                        <h4><i class="fa fa-angle-right"></i> Pessoas</h4>
                        <hr>
                        <thead>
                            <tr>
                                <th class="hidden-phone"><i class="fa fa-tag"></i> Id</th>
                                <th><i class="fa fa-user"></i> Nome</th>
                                <th class="hidden-phone"><i class="fa fa-reorder"></i> Informações Adicionais</th>
                                <th class="hidden-phone"><i class="fa fa-group"></i> Grupo</th>
                                <th class="hidden-phone"><i class="fa fa-gear"></i> Ações</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $pessoas = $pessoa->getPessoas();
                            if(count($pessoas) > 0){
                                for($i = 0; $i < count($pessoas); $i++){
                                    echo "<tr>";
                                    foreach($pessoas[$i] as $pessoa => $valor){
                                        echo "<td class='hidden-phone'>$valor</td>";
                                    } ?>
                                    <td>
                                        <a href="index.php?p=edit_pessoa&edit_person_id=<?php echo $pessoas[$i]['person_id']?>&group_id=<?php echo $pessoas[$i]['id_grupo']?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                        <a href="index.php?p=cad_pessoa&delete_person_id=<?php echo $pessoas[$i]['person_id']?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                <?php echo "<tr>"; 
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <br><button type="button" class="btn btn-success" onclick="NovoCadastro('div-cadastro')">Nova Pessoa</button>
            </div>

        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->

    <div class="form-panel" style="display: block;" id="div-cadastro">
        <h4 class="mb"><i class="fa fa-angle-right"></i> Nova Pessoa</h4>
        <form class="form-horizontal style-form" method="post" id="form-cadastro">
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label" >Nome</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" value="<?php if(isset($dados)) { echo $dados['nome'];} ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label" >Informações Adicionais</label>
                <div class="col-sm-10">
                    <textarea type="text" class="form-control" name="userData" id="userData"><?php if(isset($dados)) { echo $dados['info'];} ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Grupo</label>
                <div class="col-sm-10">
                    <select class="form-control" name="id_grupo" id="id_grupo">
                <?php if(!isset($dados)){  
                        $grupos = $grupo->getGroups();
                        if ( count($grupos) > 0) {
                            for( $i = 0; $i < count($grupos); $i++){ ?>
                                <option><?php echo $grupos[$i]['id_grupo']?></option>
                <?php       }
                        }
                       } else {?>
                            <option>O grupo não pode ser alterado!</option>
                <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Person ID</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="personId" id="personId" value="<?php if(isset($dados)) { echo 'O personID não pode ser alterado!'; }?>">
                </div>
            </div>

            <div class="form-group" style="display: none;" id="inputImagem">
                <label class="col-sm-2 col-sm-2 control-label">Adicione uma imagem do rosto da pessoa</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" name="imagem" id="imagem">
                </div>
            </div>

            <div style="background-color: #000;">

            </div>

            <input type="submit" class="btn btn-primary" name='salvar' onclick="salvarPessoa(this.value)" value='<?php if(isset($dados)){ echo "Atualizar"; } else { echo "Cadastrar"; }?>'>
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
    <script src="scripts/pessoa_script.js"></script>
</body>

</html>