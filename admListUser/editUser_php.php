<?php
    include('../connections/connection.php');

    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: ../login/login.php");
        exit; 
    }
    else if ($_SESSION["role"] != "admin") {
        echo "<script>
                window.history.back();
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
            $role = $_POST["selesctRole"];
            $id = $_POST["hidId"];
            $sql = "UPDATE USERS SET NAME = '$name', CPF = '$cpf', EMAIL = '$login', DATA_DE_NASCIMENTO ='$dataNacimento', ROLE = '$role' WHERE id_user = $id";
            $result = $conn->query($sql);

            if ($result === TRUE) {
?>
<script>
    location.href = './listUsers.php?result=4';
</script>
<?php
            }
            else {
?>
<script>
    location.href = './addUser.php?error';
</script>
<?php
            }
?>
    </body>
</html>