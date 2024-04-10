<?php
    $servername = "localhost";
    $username = "root"; 
    $password = "PUCPR1234";//alterar senha 
    $dbname = "dbFlyBoard";

    $conn = new mysqli($servername, $username, $password, $dbname,3306);//aterar a porta do sql
    if ($conn->connect_error) {
        die("Conexão falhou: $conn->connect_error");
    }
    
?>  