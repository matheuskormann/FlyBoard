<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit;
} else if ($_SESSION["role"] == "admin") {
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
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $role = $_POST["selesctRole"];
    $userImagePath = "../imagens/padraoUser.png";

    $sql = "SELECT * FROM USERS WHERE EMAIL = '$login'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        echo "<script>
                location.href = './addUser.php?errorEmail';
            </script>";
    } else {
        $sql2 = "INSERT INTO USERS (NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, PASSWORD, ROLE, USERIMAGEPATH) VALUES('$name', '$cpf', '$login', '$dataNacimento', '$hashedPassword', '$role', '$userImagePath')";
        $result = $conn->query($sql2);

        if ($result === TRUE) {
    ?>
        <script>
            location.href = './listUsers.php?result=3'; 
        </script>
                <?php
            } else {
                ?>
                <script>
                    location.href = './addUser.php?error';
                </script>
    <?php
            }
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
    } 
?> 