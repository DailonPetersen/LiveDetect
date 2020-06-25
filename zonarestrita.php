
LOGGGOUUU PORRA

<a href="sair.php">Sair</a>

<?php

    session_start();
    if( !isset($_SESSION['nomedeusuario']) ){
        header("location: login.php");
        exit;
    } else {
        header("location: index.php");
        exit;
    }    
?>