<?php
    $servername = "localhost";
    $username = "root"; 
    $password = "";//alterar senha 
    $dbname = "FLYBOARD";

    $conn = new mysqli($servername, $username, $password, $dbname,3306);//aterar a porta do sql
    if ($conn->connect_error) {
        die("Conexão falhou: $conn->connect_error");
    }
     
