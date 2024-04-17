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
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $role = "funcionario";
            $userImagePath ="../imagens/padraoUser.png";
            
            $sqlEmail = "SELECT * FROM USERS WHERE EMAIL = '$login'";
            $resultadoEmail = $conn->query($sqlEmail);
        
            if ($resultado->num_rows > 0) {
                echo "<script>
                        location.href = './cadFuncionario.php?errorEmail';
                    </script>";
            } 
            $sqlCpf = "SELECT * FROM USERS WHERE CPF = '$cpf'";
            $resultadoCpf = $conn->query($sqlCpf);
            if ($resultadoCpf->num_rows > 0) {
                echo "<script>
                        location.href = './cadFuncionario.php?errorCpf';
                    </script>";
            }
            else {
                $sql = "INSERT INTO USERS (NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, PASSWORD, ROLE, USERIMAGEPATH) VALUES('$name', '$cpf', '$login', '$dataNacimento', '$hashedPassword', '$role', '$userImagePath')";
                $result = $conn->query($sql);
        
                if ($result === TRUE) {
            ?>
                <script>
                    location.href = './listUsers.php?result=3'; 
                </script>
        <?php
                    } else {
                        ?>
                        <script>
                            location.href = './cadFuncionario.php?error';
                        </script>
<?php
            }
?>
    </body>
</html>
<?php
    if (isset($_GET['error'])){
        echo "<script>
        const ToastError = document.getElementById('ToastError')

        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastError)
        toastBootstrap.show()
        </script>";
    } }
?>