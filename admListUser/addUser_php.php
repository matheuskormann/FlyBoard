<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit;
} else if ($_SESSION["role"] == "admin") {
    echo "<script>
                window.location.href = '../index/index.html';
              </script>";
    exit;
}
?>
<html>

<head>
    <title>Dados do usuário</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../imagens/flyboardLOGOremovido.ico" type="image/x-icon">
</head>

<body>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
<div id="ToastRegex" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>
</div>

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

    $sqlEmail = "SELECT * FROM USERS WHERE EMAIL = '$login'";
    $resultadoEmail = $conn->query($sqlEmail);

    if ($resultado->num_rows > 0) {
        echo "<script>
                location.href = './addUser.php?errorEmail';
            </script>";
    } 
    $sqlCpf = "SELECT * FROM USERS WHERE CPF = '$cpf'";
    $resultadoCpf = $conn->query($sqlCpf);
    if ($resultadoCpf->num_rows > 0) {
        echo "<script>
                location.href = './addUser.php?errorCpf';
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
                    location.href = './addUser.php?error';
                </script>
<?php
            }
        }
    ?>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script> 
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