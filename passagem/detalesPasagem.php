<?php
include('../connections/connection.php');
session_start();
if (!isset($_SESSION["id"])) {
  header("Location: ../login/login.php ");
}


// IDs específicos de usuário e voo
$id_usuario = $_SESSION["id"];
$id_voo = $_GET["idVoo"];// Substitua pelo ID do voo desejado

// Query para selecionar passagens e voos do usuário específico para o voo específico
$sql = "SELECT PASSAGENS.*, VOOS.*
        FROM PASSAGENS
        INNER JOIN VOOS ON PASSAGENS.FK_VOOS_ID_VOO = VOOS.ID_VOO
        WHERE PASSAGENS.FK_USERS_ID_USER = $id_usuario
        AND VOOS.ID_VOO = $id_voo";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Exibir os dados
    while($row = $result->fetch_assoc()) {
        echo "ID da Passagem: " . $row["ID_PASSAGEM"]. " - Nome do Passageiro: " . $row["NOME_PASSAGEIRO"]. " - Código do Voo: " . $row["CODIGO_VOO"]. "<br>";
    }
} else {
    echo "Nenhuma passagem encontrada para este usuário neste voo.";
}

$conn->close();
?>
