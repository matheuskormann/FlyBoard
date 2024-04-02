<?php
    include('../connections/connection.php');

    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: ../login/login.html");
        exit; 
    }
    else if ($_SESSION["role"] == "admin") {
        echo "<script>
                alert('Você não tem permissão!');
                window.location.href = '../index/index.html';
              </script>";
        exit; 
    }
 else{
    $id = $_GET["id"];
    $sql = "DELETE FROM users WHERE id_user = $id";
    $result = $conn->query($sql);

    if ($result === TRUE) {
?>
<script>
alert('Usuário removido com sucesso!!!');
location.href = './listUsers.php';
</script>
<?php
    }
    else {
?>
<script>
alert('Algo não deu certo...');
history.go(-1);
</script>
<?php
    }
}
?>