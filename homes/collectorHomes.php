<?php
include('../connections/connection.php');
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php ");
}

$id = $_SESSION["id"];
$sql = "SELECT ROLE FROM USERS WHERE ID_USER = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$role = $row["ROLE"];



if ($role == "cliente") {
    if (isset($_GET["result"])) {
        $result = $_GET["result"];
        if ($result == 'semPermissao') {
            header("Location: ./homeCliente.php?result=semPermissao");
        }
        else{
            header("Location: ./homeCliente.php?result=erro");
        }
    }
    else{
        header("Location: ./homeCliente.php");
    }
} elseif ($role == "funcionario") {
    if (isset($_GET["result"])) {
        $result = $_GET["result"];
        if ($result == 'semPermissao') {
            header("Location: ./homeFuncionario.php?result=semPermissao");
        }
        else{
            header("Location: ./homeFuncionario.php?result=erro");
        }
    }
    else{
        header("Location: ./homeFuncionario.php");
    }   
} elseif ($role == "admin") {
    if (isset($_GET["result"])) {
        $result = $_GET["result"];
        if ($result == 'erro') {
            header("Location: ./homeAdmin.php?result=erro");
        }
    }
    else{
    header("Location: ./homeAdmin.php");
    }
}
else{
    header("Location: ../login/login.php?result=erro");
}
