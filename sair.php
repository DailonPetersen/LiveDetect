<?php

    session_start();
    unset($_SESSION['nomedeusuario']);
    header("location: login.php");
?>