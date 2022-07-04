<?php
    session_start();
    $_SESSION["log_in"] = NULL;
    $_SESSION["id"] = NULL;
    $_SESSION["username"] = NULL;
    unset($_SESSION["log_in"]);
    unset($_SESSION["id"]);
    unset($_SESSION["username"]);
    unset($_SESSION["role"]);
    unset($_SESSION['played']);
    session_destroy();
    
    header("location: ../view/login.php");
    exit();
?>