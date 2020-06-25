<?php

require_once 'classes/Grupo.php';
$grupo = new Grupo;


if (isset($_POST['form']) || isset($_POST['groupName']) ) //tanto pra novos cadastros quanto para edicoes
{
    if ( isset($_GET['update_id']) && !empty(isset($_GET['update_id'])) ){
        $nomedogrupo = addslashes($_POST['groupName']);
        $infodogrupo = addslashes($_POST['groupData']);
        $id_grupo = addslashes($_POST['groupId']);
        if (!empty($infodogrupo) && !empty($nomedogrupo)) {
            if ( $grupo->updateById($id_grupo, $nomedogrupo, $infodogrupo) ){
                $msg = "OK";
                var_dump($msg, $nomedogrupo, $infodogrupo, $id_grupo);
            } else{
                $msg = "NOK";
                var_dump($msg);
            }
            
        } else {
            $msg = "Preencha os campos!";
        }
    } else {
        $nomedogrupo = addslashes($_POST['groupName']);
        $infodogrupo = addslashes($_POST['groupData']);
        $id_grupo = addslashes($_POST['groupId']);
        if (!empty($infodogrupo) && !empty($nomedogrupo)) {
            if ( $grupo->create($id_grupo, $nomedogrupo, $infodogrupo) ){
                $msg = "OK";
                var_dump($msg, $nomedogrupo, $infodogrupo, $id_grupo);
            } else{
                $msg = "NOK";
                var_dump($msg);
            }
            
        } else {
            $msg = "Preencha os campos!";
        }
    }
}


if(isset($_GET['delete_id'])){
    $id_grupo = addslashes($_GET['delete_id']); 
    $grupo->deleteById($id_grupo);
}

if(isset($_GET['update_id'])){
    $update_id = addslashes($_GET['update_id']);
    $dados = $grupo->selectById($update_id);
}

?>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Grupos</title>
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
                        <h4><i class="fa fa-angle-right"></i> Grupos</h4>
                        <hr>
                        <thead>
                            <tr>
                                <th class="hidden-phone"><i class="fa fa-tag"></i> Id</th>
                                <th><i class="fa fa-group"></i> Nome do Grupo</th>
                                <th class="hidden-phone"><i class="fa fa-reorder"></i> Descrição</th>
                                <th class="hidden-phone"><i class="fa fa-gear"></i> Ações</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $grupos = $grupo->getGroups();
                            if (count($grupos) > 0) {
                                for ($i = 0; $i < count($grupos); $i++) {
                                    echo "<tr>";
                                    foreach ($grupos[$i] as $user => $valor) {
                                            echo "<td class='hidden-phone'>$valor</td>";
                                    } ?>
                                    <td>
                                        <a href="index.php?p=cad_grupo&update_id=<?php echo $grupos[$i]['id_grupo'] ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                        <a href="index.php?p=cad_grupo&delete_id=<?php echo $grupos[$i]['id_grupo'] ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                                    </td>
                            <?php echo "<tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <br><button type="button" class="btn btn-success" name="salvar" onclick="NovoCadastro('div-cadastro')">Novo Grupo</button>
            </div>

        </div><!-- /content-panel -->
    </div><!-- /col-md-12 -->

    <div class="form-panel" style="display: block;" id="div-cadastro">
        <h4 class="mb"><i class="fa fa-angle-right"></i> Novo Grupo</h4>
        <form class="form-horizontal style-form" method="POST" id="form-cadastro">
            <div class="form-group" id="nomegrupo">
                <label class="col-sm-2 col-sm-2 control-label">Nome do Grupo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php if(isset($dados)) { echo $dados['nome_grupo'];} ?>" id="groupName" name="groupName">
                </div>
            </div>
            <div class="form-group" id="id_grupo" style="display: block">
                <label class="col-sm-2 col-sm-2 control-label">Id_grupo</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php if(isset($dados)) { echo $dados['id_grupo'];} ?>" id="groupId" name="groupId">
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Descrição</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?php if(isset($dados)) { echo $dados['info_grupo'];} ?>" id="groupData" name="groupData">
                </div>
            </div>

            <div style="background-color: #000;">

            </div>

            <input type="submit" class="btn btn-primary" name="salvar" id="salvar" onclick="salvarGrupo(this.value)" value="<?php if(isset($dados)){ echo "Atualizar"; } else { echo "Cadastrar"; }?>">
            <button type="button" class="btn btn-danger" onclick="CancelarCadastro('div-cadastro')">Cancelar</button>
     </form>
    </div>
    <script src="scripts/grupo_script.js"></script>
</body>

</html>