<?php
    require_once 'classes/Usuario.php';
    $usuario = new Usuario;
    session_start();

if(isset($_POST['email']))
{
    $email = addslashes($_POST['email']);
    $nomeDeUsuario = addslashes($_POST['nomeDeUsuario']);
    $senha = addslashes($_POST['senha']);
    $confirmarSenha = addslashes($_POST['confirmarSenha']);

    if( !empty($email) && !empty($nomeDeUsuario) && !empty($senha) && !empty($confirmarSenha) )
    {
        $usuario->connect();
        if ( $usuario->msgErro == ""){
           if ( $senha == $confirmarSenha ){
                if($usuario->create($email, $nomeDeUsuario, $senha, $confirmarSenha)) {
                    $msg = "Cadastrado com sucesso!";
                    header("location: login.php");
                }
                else {
                    $msg = "Nome de usuario já cadastrado!";

                }
           } else {
                $msg = "As senhas não estão iguais";
           }
        } else {
            $msg = "Erro: ".$u->msgErro;
        }
    } else {
        $msg = "Preencha os campos!";
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
        <form method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email"  name="email" aria-describedby="emailHelp" placeholder="Enter">
            </div>
            <div class="form-group">
                <label for="nomeDeUsuario">Nome de Usuario</label>
                <input type="text" class="form-control" id="nomeDeUsuario" name="nomeDeUsuario" aria-describedby="seu nome de usuario caralho" placeholder="Nome de usuario...">
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="senha...">
            </div>
            <div class="form-group">
                <label for="confirmarSenha">Confirme a senha</label>
                <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" placeholder="senha...">
            </div>
            <!--            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            <button type="submit" class="btn btn-primary">Loggin</button>
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