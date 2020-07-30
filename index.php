<?php
session_start();
if (!isset($_SESSION['nomedeusuario'])) {
    header("location: login/login.php");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">

    <title>Live Detect</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">

    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
</head>

<body>

    <section id="container">

        <header class="header black-bg">
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <a href="index.php" class="logo"><b>LIVE DETECT</b></a>


            <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <li><a class="logout" href="login/logout.php"><?php echo $_SESSION['nomedeusuario'] ?> - Logout</a></li>
                </ul>
            </div>
        </header>

        <aside>
            <div id="sidebar" class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu" id="nav-accordion">

                    <p class="centered"><a href="#"><img src="assets/img/ui.png" class="img-circle" width="60"></a></p>
                    <h5 class="centered"><?php echo $_SESSION['nomedeusuario'] ?></h5>

                    <li class="mt">
                        <a class="active" href="index.php?p=dashboard">
                            <i class="fa fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-edit"></i>
                            <span>Cadastros</span>
                        </a>
                        <ul class="sub">
                            <li><a href="index.php?p=cad_usuario">Usuários</a></li>
                        </ul>
                        <ul class="sub">
                            <li><a href="index.php?p=cad_grupo">Grupos</a></li>
                        </ul>
                        <ul class="sub">
                            <li><a href="index.php?p=cad_pessoa">Pessoas</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-gear"></i>
                            <span>Opções</span>
                        </a>
                        <ul class="sub">
                            <li><a href="index.php?p=parametros">Parâmetros do Sistema</a></li>
                        </ul>
                        <ul class="sub">
                            <li><a href="index.php?p=livedetect">Iniciar Detecção</a></li>
                        </ul>
                    </li>
                    
                    <li class="sub-menu">
                        <a href="index.php?p=sobre">
                            <span>Sobre</span>
                        </a>
                    </li>

                </ul>
                    <!-- sidebar menu end-->
            </div>
        </aside>

        <section id="main-content">
            <section class="wrapper">
                <?php

                $menu = @$_GET['p'];

                switch ($menu) {
                    case 'cad_usuario':
                        include_once 'cad_usuario.php';
                        break;
                    case 'cad_grupo':
                        include_once 'cad_grupo.php';
                        break;
                    case 'cad_pessoa':
                        include_once 'cad_pessoa.php';
                        break;
                    case 'dashboard':
                        include_once 'dashboard.php';
                        break;
                    case 'edit_pessoa':
                        include_once 'edit_pessoa.php';
                        break;
                    case 'livedetect':
                        include_once 'livedetect.php';
                        break;
                    case 'parametros':
                        include_once 'parametros.php';
                        break;
                    case 'sobre':
                        include_once 'sobre.php';
                        break;
                }


                ?>
            </section>
        </section>
    </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>
    <script src="assets/js/zabuto_calendar.js"></script>

    <script type="application/javascript">
        $(document).ready(function() {
            $("#date-popover").popover({
                html: true,
                trigger: "manual"
            });
            $("#date-popover").hide();
            $("#date-popover").click(function(e) {
                $(this).hide();
            });

            $("#my-calendar").zabuto_calendar({
                action: function() {
                    return myDateFunction(this.id, false);
                },
                action_nav: function() {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [{
                        type: "text",
                        label: "Special event",
                        badge: "00"
                    },
                    {
                        type: "block",
                        label: "Regular event",
                    }
                ]
            });
        });


        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script>


</body>

</html>