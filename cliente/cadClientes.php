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
            $role = "cliente";
            $userImagePath ="../imagens/padraoUser.png";

            
            $sql = "INSERT INTO users (name, cpf, login, data_de_nacimento, password, role, userImagePath) VALUES('$name', '$cpf', '$login', '$dataNacimento', '$password', '$role', '$userImagePath')";
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