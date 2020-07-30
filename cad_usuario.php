<?php
require_once 'classes/Usuario.php';
$usuario = new Usuario;

if (isset($_POST['salvar'])) //tanto pra novos cadastros quanto para edicoes
{
    // ------------------------EDITAR---------------------------------------
    if (isset($_GET['id_update']) && !empty(isset($_GET['id_update']))) {
        $email = addslashes($_POST['email']);
        $nomeDeUsuario = addslashes($_POST['usuario']);
        $senha = addslashes($_POST['senha']);
        $confirmarSenha = addslashes($_POST['confirmarSenha']);
        $id_usuario = $_GET['id_update'];

        if (!empty($email) && !empty($nomeDeUsuario) && !empty($senha) && !empty($confirmarSenha)) {
            if ($senha == $confirmarSenha) {
                if (!$usuario->updateById($nomeDeUsuario, $email, $senha, $id_usuario)) {
                    $msg = "Atualizado com sucesso!";
                } else {
                    $msg = "Inconformidade no banco de dados.";
                }
            } else {
                $msg = "As senhas não estão iguais";
            }
        } else {
            $msg = "Preencha todos os campos!";
        }
    }
    // ------------------------CADASTRAR---------------------------------------
    else {
        $email = addslashes($_POST['email']);
        $nomeDeUsuario = addslashes($_POST['usuario']);
        $senha = addslashes($_POST['senha']);
        $confirmarSenha = addslashes($_POST['confirmarSenha']);
        if (!empty($email) && !empty($nomeDeUsuario) && !empty($senha) && !empty($confirmarSenha)) {
            if ($senha == $confirmarSenha) {
                if ($usuario->create($email, $nomeDeUsuario, $senha)) {
                    $msg = "Cadastrado com sucesso!";
                } else {
                    $msg = "Nome de usuario já cadastrado!";
                }
            } else {
                $msg = "As senhas não estão iguais";
            }
        } else {
            $msg = "Preencha todos os campos!";
        }
    }
}

if (isset($_GET['username'])) {
    $nomedeusuario = addslashes($_GET['username']);
    $usuario->deleteByName($nomedeusuario);
}

if (isset($_GET['id_update'])) {
    $id_update = addslashes($_GET['id_update']);
    $dados = $usuario->selectById($id_update);
}

?>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
</head>

<script>
    function NovoUsuario(el) {
        var display = document.getElementById(el).style.display;
        if (display == "none") {
            document.getElementById(el).style.display = 'block';
            window.location.href = '#form-cadastro';
        }
    }

    function CancelarEdicao(){
        location.href="index.php?p=cad_usuario";
    }
</script>

<body>
    <div class="form-panel">
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <table class="table table-striped table-advance table-hover">
                        <h4><i class="fa fa-angle-right"></i> Usuários Cadastrados</h4>
                        <hr>
                        <thead>
                            <tr>
                                <th><i class="fa fa-user"></i> E-mail</th>
                                <th class="hidden-phone"><i class="fa fa-lock"></i> Usuário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $usuarios = $usuario->getUsers();
                            if (count($usuarios) > 0) {
                                for ($i = 0; $i < count($usuarios); $i++) {
                                    echo "<tr>";
                                    foreach ($usuarios[$i] as $user => $valor) {
                                        if ($user != 'id_usuario') {
                                            echo "<td class='hidden-phone'>$valor</td>";
                                        }
                                    } ?>
                                    <td>
                                        <a href="index.php?p=cad_usuario&id_update=<?php echo $usuarios[$i]['id_usuario'] ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                        <a href="index.php?p=cad_usuario&username=<?php echo $usuarios[$i]['nomedeusuario'] ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                                    </td>
                            <?php echo "<tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div><!-- /content-panel -->
                <br><button type="button" class="btn btn-success" name="salvar" onclick="NovoUsuario('div-cadastro')">Novo Usuario</button>
            </div><!-- /col-md-12 -->
        </div>
    </div>

    <div class="form-panel" style="display: block;" id="div-cadastro">
        <h4 class="mb"><i class="fa fa-angle-right"></i> Novo Usuário</h4>
        <form class="form-horizontal style-form" method="POST">
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">E-mail</label>
                <div class="col-sm-10">
                    <input type="text" id="email" name="email" class="form-control" value="<?php if (isset($dados)) {
                                                                                                echo $dados['email'];
                                                                                            } ?>" placeholder="email...">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Usuário</label>
                <div class="col-sm-10">
                    <input type="text" id="usuario" name="usuario" class="form-control" value="<?php if (isset($dados)) {
                                                                                                    echo $dados['nomedeusuario'];
                                                                                                } ?>" placeholder="usuario...">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Senha</label>
                <div class="col-sm-10">
                    <input type="password" id="senha" name="senha" class="form-control" placeholder="senha...">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 col-sm-2 control-label">Repetir Senha</label>
                <div class="col-sm-10">
                    <input type="password" id="confirmarSenha" name="confirmarSenha" class="form-control" placeholder="senha...">
                </div>
            </div>

            <input type="submit" class="btn btn-primary" name="salvar" value="<?php if (isset($dados)) {
                                                                                    echo "Atualizar";
                                                                                } else {
                                                                                    echo "Cadastrar";
                                                                                } ?>">
            <input type="button" class="btn btn-danger" id="cancelar" name="cancelar" value="Cancelar" onclick="CancelarEdicao()">
        </form>
        <hr>
        <?php
        if (isset($msg)) {
        ?>
            <p class="msg" style="color: red;"><?php echo $msg ?></p>
        <?php
        }
        ?>
    </div>
</body>

</html>