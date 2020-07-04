<?php
require_once 'classes/Conexao.php';
require_once 'classes/Usuario.php';
$conexao = new Conexao;
$usuario = new Usuario;

?>

<?php
session_start();

if (isset($_POST['inputUsuario'])) {
    $username = $_POST['inputUsuario'];
    $pass = $_POST['senha'];

    if (!empty($_POST['inputUsuario']) && !empty($_POST['senha'])) {
        $conexao->connect();
        if ($usuario->msgErro != "") {
            $msg = $usuario->msgErro;
            var_dump($usuario->msgErro);
        } else {
            if (!($usuario->loggin($username, $pass))) {
                $msg = "Impossivel Logar!";
            } else {
                header("location: zonarestrita.php");
            }
        }
    }
}
?>
<html lang="pt-br">

<head>
    <meta charset="utf-8">

    <title>Live Detect</title>

    <link href="./assets/css/bootstrap.css" rel="stylesheet">
    <link href="./assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <link href="./assets/css/style.css" rel="stylesheet">
    <link href="./assets/css/style-responsive.css" rel="stylesheet">
    <link href="./css/login.css">
</head>

<body>
    <div id="login-page">
        <div class="container">
            <form class="form-login" method="POST" action="login.php">
                <h2 class="form-login-heading">ENTRAR</h2>
                <div class="login-wrap">
                    <input type="text" class="form-control" id="inputUsuario" name="inputUsuario" placeholder="Nome de Usuario" autofocus>
                    <br>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha">
                    <label class="checkbox">
                        <span class="pull-right">
                            <a data-toggle="modal" href="login.html#myModal"> Esqueceu sua senha?</a>

                        </span>
                    </label>
                    <button class="btn btn-theme btn-block" href="index.php" type="submit"><i class="fa fa-lock"></i> LOGIN</button>
                    <hr>

                </div>

                <!-- Modal -->
                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Esqueceu sua senha?</h4>
                            </div>
                            <div class="modal-body">
                                <p>Entre com seu endereço de e-mail para resetar a senha.</p>
                                <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                            </div>
                            <div class="modal-footer">
                                <button data-dismiss="modal" class="btn btn-default" type="button">Cancelar</button>
                                <button class="btn btn-theme" type="button">Enviar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal -->
                <span><?php echo @$msg; ?></span>

            </form>
        </div>
    </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {
            speed: 1000
        });
    </script>


</body>

</html>