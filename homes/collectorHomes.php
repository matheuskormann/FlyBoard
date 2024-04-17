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

?>
<?php
if ($role == "cliente") {
    header("Location: ./homeCliente.php");
} elseif ($role == "funcionario") {
    header("Location: ./homeFuncionario.php");
} elseif ($role == "admin") {
    header("Location: ./homeAdmin.php");
} else {
    header("Location: ../index/index.php");
}
?>