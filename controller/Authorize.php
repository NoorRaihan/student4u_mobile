<?php
session_start();

    if(!isset($_SESSION["log_in"]) || $_SESSION["log_in"] !== True){
        header("location: login.php");
        exit();

    }

?>