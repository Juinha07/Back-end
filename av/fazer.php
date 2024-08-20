<?php

    session_start();
    if(empty($_SESSION)){
        echo"<script>location.href='agendar.php';</script>";
    } 
    include_once('conexao.php');
    $logado =$_SESSION['cliente'];
    $sql = "select * from cliente";
    $result = $con->query($sql);
    //print_r($result);
?>