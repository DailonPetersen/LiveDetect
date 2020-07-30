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
        SELECT emo.*, date_format(emo.data, '%d/%m/%Y %H:%i ') data,
        pes.nome FROM emocoes AS emo 
        INNER JOIN pessoas AS pes 
        ON emo.person_id = pes.person_id 
        WHERE pes.nome = :pessoa_nome 
        AND emo.data BETWEEN :data_ini AND :data_fim");

$pessoa_nome = $_GET["pessoa_select"];
$data_ini = $_GET["data_ini"];
$data_fim = $_GET["data_fim"];

$query->bindValue(":pessoa_nome", $pessoa_nome);
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
            const data = new google.visualization.arrayToDataTable([
                ['Data', 'Raiva', 'Desprezo', 'Repulsa', 'Felicidade', 'Neutro', 'Tristeza', 'Surpresa'],

                <?php

                for ($i = 0; $i < $size; $i++) {
                ?>['<?php echo  $dados[$i]['data']; ?>', <?php echo $dados[$i]['anger'] ?>, <?php echo $dados[$i]['contempt'] ?>, <?php echo $dados[$i]['disgust'] ?>,
                        <?php echo $dados[$i]['happiness'] ?>, <?php echo $dados[$i]['neutral'] ?>, <?php echo $dados[$i]['sadness'] ?>, <?php echo $dados[$i]['surprise'] ?>
                    ],
                <?php }

                $formated_date_ini = date('d-m-Y', strtotime($data_ini));
                $formated_date_fim = date('d-m-Y', strtotime($data_fim));

                ?>

            ])

            const options = {
                title: '<?php echo $pessoa_nome; ?> - Período: <?php echo $formated_date_ini ?> a <?php echo $formated_date_fim  ?>',
                //isStacked: 'percent',
                vAxis: {
                    format: 'percent'
                },
                height: 800,
                width: 1800
            }

            const chart = new google.visualization.ColumnChart(container)
            chart.draw(data, options)
        }
    </script>
</body>

</html>