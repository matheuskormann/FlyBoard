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
?>
<html>
    <head>
        <title>Dados do usuário</title>
    </head>
    <body>
        <?php
            include('../connections/connection.php');

            $name = $_POST["txtName"];
            $cpf = $_POST["txtCpf"];
            $login = $_POST["txtLogin"];
            $dataNacimento = $_POST["txtDtNasc"];
            $password = $_POST["txtPassword"];
            $role = $_POST["selesctRole"];
            $id = $_POST["hidId"];
            $sql = "UPDATE USERS SET NAME = '$name', CPF = '$cpf', EMAIL = '$login', DATA_DE_NASCIMENTO ='$dataNacimento', PASSWORD = '$password', ROLE = '$role' WHERE id_user = $id";
            $result = $conn->query($sql);

            if ($result === TRUE) {
?>
<script>
    alert('Usuário cadastrado com sucesso!!!');
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
?>
    </body>
</html>