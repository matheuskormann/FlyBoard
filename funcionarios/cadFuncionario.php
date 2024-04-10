<html>
    <head>
        <title>Dados do usuário</title>
    </head>
    <body>
        <?php
            include('../connections/connection.php');

            $name = $_POST["txtName"];
            $cpf = $_POST["txtCpf"];
            $email = $_POST["txtLogin"];
            $dataNascimento = $_POST["txtDtNasc"];
            $password = $_POST["txtPassword"];
            $role = "funcionario";
            $userImagePath ="../imagens/padraoUser.png";
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO USERS (NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, PASSWORD, ROLE, USERIMAGEPATH) VALUES('$name', '$cpf', '$email', '$dataNascimento', '$password_hashed', '$role' , '$userImagePath')";
            $result = $conn->query($sql);

            if ($result === TRUE) {
?>
<script>
    alert('Usuário cadastrado com sucesso!!!');
    location.href = '../index/index.php';
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