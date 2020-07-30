<?php

require_once 'Conexao.php';
$conexao = new Conexao;

if ($conexao->connect()) {
    echo "Connect";
} else {
    echo $conexao->msgErro;
}

global $pdo;

$query = $pdo->prepare("
        SELECT emo.happiness, date_format(emo.data, '%d/%m/%Y') data,
        gru.nome_grupo FROM emocoes AS emo 
        INNER JOIN grupos AS gru ON emo.group_id = gru.id_grupo
        WHERE gru.nome_grupo = :group
        AND emo.data BETWEEN :data_ini AND :data_fim
        ORDER BY emo.data");

$grupo = $_GET["grupo_select"];
$data_ini = $_GET["data_ini"];
$data_fim = $_GET["data_fim"];

$query->bindValue(":group", $grupo);
$query->bindValue(":data_ini", $data_ini);
$query->bindValue(":data_fim", $data_fim);
$query->execute();
$dados = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<html>

<head>
    <style>
        body{
            background: linear-gradient(0deg, rgba(0,38,194,1) 0%, rgba(56,117,255,0.8463760504201681) 100%); 
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-panel{
            margin: 0;
            padding: 0;
        }
        #chart{
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="form-panel">
        <div id="chart"></div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        google.charts.load('current', {
            packages: ['corechart']
        })
        <?php
        $size = count($dados);

        
        if ($size > 0) {
            echo "google.charts.setOnLoadCallback(drawChart)";
        } else {
            echo "
            var div = document.getElementById('chart');
            div.innerHTML = '<h1>Não foram encontrados dados para os fitros informados.</h1>';
            ";
        }

        ?>

        function drawChart() {

            const container = document.querySelector('#chart')
            var data = google.visualization.arrayToDataTable([
                ['Periodo', 'Hapinness'],
                <?php

                for ($i = 0; $i < $size; $i++) {
                    $data = DateTime::createFromFormat('d/m/Y', $dados[$i]['data'])->format('d-m');
                    ?>
                    ['<?php echo $data ?>', <?php echo $dados[$i]['happiness']; ?>],
                        
        <?php   }  ?>
        
            ]);

            const options = {
                title: '<?php echo  $grupo; ?>',
                curveType: 'function',
                legend: { position: 'bottom' },
                height: 800,
                width: 1800
            }

            var chart = new google.visualization.LineChart(container);
            chart.draw(data, options);
        }
    </script>
</body>

</html>