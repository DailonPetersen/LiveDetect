<?php
require_once 'classes/Conexao.php';
require_once 'classes/Grupo.php';
require_once 'classes/Pessoa.php';

$conexao = new Conexao;
$grupo = new Grupo;
$pessoa = new Pessoa;

if ($conexao->connect()) {
  echo "Connect";
} else {
  echo $conexao->msgErro;
}

?>

<html>
<head>
</head>

<body>

  <div class="row mt">
    <div class="col-lg-12">
      <div class="form-panel">
        <h4 class="mb"><i class="fa fa-angle-right"></i> Dashboard - Selecione os dados a serem exibidos conforme os filtros abaixo</h4>

        <label>Pessoa</label>
        <form method="get" action="classes/gera_dashboard.php">
          <select class="form-control" name="pessoa_select">
            <option>-- Selecionar --</option>
            <?php
            $pessoas = $pessoa->getPessoas();
            if (count($pessoas) > 0) {
              for ($i = 0; $i < count($pessoas); $i++) { ?>
                <option><?php echo $pessoas[$i]['nome'] ?></option>
            <?php       }
            }
            ?>
          </select>
          <br>
          <label>Período</label>
          <br>
          <label>De: </label> <input name="data_ini" type="datetime-local"> <label>A: </label> <input name="data_fim" type="datetime-local">
          <div style="padding: 20pt;">
            <input type="submit" class="btn btn-primary" value="Exibir">
          </div>
        </form>
      </div>
    </div>

<!--
    <div class="row mt">
    <div class="col-lg-12">
      <div class="form-panel">
        <h4 class="mb"><i class="fa fa-angle-right"></i> Dashboard - Selecione os dados a serem exibidos conforme os filtros abaixo</h4>

        <label>Grupos</label>
        <form method="get" action="classes/gera_dashboard_group.php">
          <select class="form-control" name="grupo_select">
            <option>-- Selecionar --</option>
            <?php
            $grupos = $grupo->getGroups();
            if (count($grupos) > 0) {
              for ($i = 0; $i < count($grupos); $i++) { ?>
                <option><?php echo $grupos[$i]['nome_grupo'] ?></option>
            <?php       }
            }
            ?>
          </select>
          <br>
          <label>Período</label>
          <br>
          <label>De: </label> <input name="data_ini" type="datetime-local"> <label>A: </label> <input name="data_fim" type="datetime-local">
          <div style="padding: 20pt;">
            <input type="submit" class="btn btn-primary" value="Exibir">
          </div>
        </form>
      </div>
    </div>
    </div> -->
</body>

</html>

