<?php
include('../connections/connection.php');
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.html ");
}

$id = $_SESSION["id"];
$sql = "SELECT role FROM users WHERE id_user = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$role = $row["role"];

?>
<script>
    alert("para continuar realize o login");
</script>
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