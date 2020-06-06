<?php
    require_once 'classes/Usuario.php';
    $usuario = new Usuario;
?>

<?php
    session_start();

    
    
    if ( isset($_POST['inputUsuario']) ){
        $username = $_POST['inputUsuario'];
        $pass = $_POST['senha'];

        if ( !empty($_POST['inputUsuario']) && !empty($_POST['senha']) ){
            $usuario->connect();
            if( $usuario->msgErro != "" ){
                echo $usuario->msgErro;
                $msg = $usuario->msgErro;
            } else {
                if ( !($usuario->loggin($username, $pass)) ) {
                    $msg = "Impossivel Logar!";
                } else {
                    header("location: view.php");
                }

            }
        }


    }
?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
        <div class="container-fluid">
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="inputUsuario">Nome de Usuario</label>
                    <input type="text" class="form-control" id="inputUsuario" name="inputUsuario" aria-describedby="seu nome de usuario caralho" placeholder="Nome de usuario...">
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" class="form-control" id="senha" name="senha" placeholder="senha...">
                </div>
                <!--            <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div> -->
                <input type="submit" class="btn btn-primary" value="Loggin">
            </form>

            <?php 
                if ( isset($msg) ){
            ?>
                <p class="msg"><?php echo $msg ?></p>
            <?php 
                }
            ?>


        </div>
</body>

</html>