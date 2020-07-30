<?php
require_once 'classes/Grupo.php';
$grupo = new Grupo;
?>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>

    <style>
        .form-panel{
            margin: 1% 50% 1% 1%;
        }
        
    </style>
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
        <h4 class="mb"><i class="fa fa-angle-right"></i>Parâmetros do Sistema</h4>

        <form class="form-horizontal style-form" method="post" id="form-cadastro" action="index.php?p=livedetect">
            <div class="form-group">
                <label class="col-sm-7 control-label">Em qual grupo você deseja realizar a Detecção?</label>
                <div class="col-sm-5">
                <select name="grupoAdetectar" id="grupoAdetectar" class="form-control">
                 <option>-- Selecionar --</option>
                    <?php
                        $grupos = $grupo->getGroups();
                        if ( count($grupos) > 0) {
                            for( $i = 0; $i < count($grupos); $i++){ ?>
                                <option><?php echo $grupos[$i]['id_grupo']?></option>
                        <?php }
                        }
                    ?>
                </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-7 control-label">Qual será o intervalo(em minutos) entre a captura das fotos?</label>
                <div class="col-sm-5">
                    <input type="numer" class="form-control" name="intervalo" id="intervalo">
                </div>
            </div>

            <input type="submit" class="btn btn-primary" name='salvar' value="Salvar">
            <button type="button" class="btn btn-danger" >Fechar</button>
        </form>
    </div>

</body>

</html>