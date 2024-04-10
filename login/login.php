<?php
    include("../connections/connection.php");

    if (isset($_POST["submit"])) {

        
        $email = $_POST["txtemail"];
        $password = $_POST["txtPassword"];
    
        $sql = "SELECT ID_USER, PASSWORD , ROLE FROM USERS WHERE EMAIL = '$email'
        ";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row["PASSWORD"] == $password) {
                    header("Location:   ../homes/collectorHomes.php");
                    session_start();
                    $_SESSION["id"] = intval($row["ID_USER"]);
                    $_SESSION["role"] = intval($row["ROLE"]);
                }
                else {
    
    ?>
         
         <div style="margin-top: 9px;" class="container alert alert-danger" role="alert">
         Senha Incorreto
        </div>
         

    <?php
                }
            }
        }
        else {
    ?>
         <div style="margin-top: 9px;" class="container alert alert-danger" role="alert">
         Login Incorreta    
        </div>
    <?php
        }
    }
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./login.css">
    <link rel="shortcut icon" href="../imagens/flyboardLOGOremovido.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

</head>
<body>
    <div class="logo"><a href='../index/index.php'><img id="Logo" href='../index/index.php' src="../imagens/flyboardLOGOremovido.png" alt="Logo" ></a></div>
    <div class="conteinerLogin2">
        <form name="login" method="POST">

            <div id="Login">
                <h1>LOGIN</h1>
                <p>E-MAIL:</p>
                <input id="inputLogin" type="text" name="txtemail" required>
                <p>SENHA:</p>
                <input id="inputPasswoed" type="password" name="txtPassword">
                <a id="criarconta" href="../cliente/cadClientes.html">Criar uma conta</a>
                <br>
                <input name="submit" id="inputEnviar" type="submit" value="Enviar">
            </div>
        </form>
    </div>
    

    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
