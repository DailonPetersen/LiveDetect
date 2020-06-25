<?php

require_once 'classes/Dashboard.php';
require_once 'classes/Grupo.php';
$dashboard = new Dashboard;
$grupo = new Grupo;

if(isset($_POST['personId'])){
    $personId = $_POST['personId'];
    var_dump($personId);
    $result = $dashboard->getEmocoesPorPessoa($personId);
    echo $result;
}


?>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
</head>

<body>

    <div class="container">
        <select name="grupos" id="grupos">
            <?php
                $grupos = $grupo->getGroups();
                if ( count($grupos) > 0) {
                    for( $i = 0; $i < count($grupos); $i++){ ?>
                        <option value=><?php echo $grupos[$i]['id_grupo']?></option>
                <?php }
                }
            ?>
        </select>
        <select name="pessoas" id="pessoas" form="seleciona_grupo">

        </select>

    </div>

    <div class="tab-pane" id="chartjs">
        <div class="row mt">
            <div class="col-lg-6">
                <div class="content-panel">
                    <h4><i class="fa fa-angle-right"></i> Radar</h4>
                    <div class="panel-body text-center">
                        <canvas id="radar" height="300" width="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script defer src="scripts/dashboard_script.js"></script>
    <script src="assets/js/chart-master/Chart.js"></script>
    <script src="assets/js/chartjs-conf.js"></script>
</body>

</html>