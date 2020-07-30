<?php
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre o trabalho</title>

    <style>
        div.form-panel{
            padding: 10px;
        }
        h1, h3{
            font-weight: bold;
        }
        p, li{
            font-size: 20px;
        }
        #ass{
            font-style: italic;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="form-panel">
        <h1>Live Detect</h1>

        <p>
            A aplicação Live Detect foi desenvolvida para o trabalho de conclusão da Graduação de Análise e Desenvolvimento de Sistemas, da faculdade
            Ftec Tecnologia Novo Hamburgo no primeiro semestre do ano 2020.
        </p>

        <p>
            O sistema tem como intuito análisar as emocoes dos alunos principalmente, identificando-os e gerando uma representacao visual de suas emoções em um periodo determinado.
        </p>

        <h3>Algumas instruções de como utiliza-lo.</h3>
        <ul>
            <li>
               - Crie um grupo adicionando um nome e uma descrição. Este servirá com um conjunto para os individuos que serão adicionados na próxima etapa. O sistema irá gerar um identificado para este grupo.
            </li>
            <li>
                - Crie uma pessoa, esta deve também receber um nome e uma descrição. Para concluir o cadastro da pessoa, é necessario adicionar pelo menos duas imagens de seu rosto, com o objetivo de treinar o sistema.
            </li>
            <li>
                - Após criar a pessoa, será necessario treinar o grupo.
            </li>
            <li>
                - Selecione o grupo e intervalo entre as fotos na aba Opções > Parametros do Sistema.
            </li>
            <li>
                - Tendo treinado o grupo, é possivel iniciar a detecção na opção Iniciar Detecção..
            </li>

        </ul>

        <hr>
        <p id="ass">Desenvolvido por Dailon Petersen, Daniela Kessler, Denner Dias, Leonardo Kurylo, com consultoria do Mestre Carlos Weissheimer Junior.</p>
    </div>
    
</body>
</html>