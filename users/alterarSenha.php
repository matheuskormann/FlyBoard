<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit;
}

if (isset($_POST['novaSenha'])) {
    $id = $_SESSION["id"];
    
    // Preparar declaração para evitar injeção SQL
    $stmt = $conn->prepare("SELECT PASSWORD FROM USERS WHERE ID_USER = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($hashedPasswordAntigo);
    $stmt->fetch();
    $stmt->close();
    
    $passwordAntigo = $_POST['txAntigotPassword'];

    if (password_verify($passwordAntigo, $hashedPasswordAntigo)) {
        if ($_POST['txtNovotPassword'] === $_POST['txtComfirmNovotPassword']) {
            $passwordNovo = $_POST["txtNovotPassword"];
            $hashedPasswordNovo = password_hash($passwordNovo, PASSWORD_BCRYPT);
            
            // Preparar declaração para evitar injeção SQL
            $stmt = $conn->prepare("UPDATE USERS SET PASSWORD = ? WHERE ID_USER = ?");
            $stmt->bind_param("si", $hashedPasswordNovo, $id);
            if ($stmt->execute()) {
                echo "<script>
                        alert('Senha atualizada com sucesso!');
                        window.location.href = './comfig.php';
                      </script>";
            } else {
                echo "<script>alert('Algo deu errado...');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('As senhas não conferem!');</script>";
        }
    } else {
        echo "<script>alert('Senha atual incorreta!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <form action="" method="post">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>alterar Senha</title>
    <link rel="stylesheet" href="comfig.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
    <a id="botaoVoltar" type="button" class="btn btn-light" href="./comfig.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>

<div class="container">
  <div class="row">
    <div class="col">
    </div>
    <div class="col">
    <label for="inputPassword5" class="form-label">Password Atual:</label>
<input type="password" name="txAntigotPassword" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
<br>
<hr>
<br>
<form action="" method="post">
<label for="inputPassword5" class="form-label">Novo Password: </label>
<input type="password" name="txtNovotPassword" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
<div id="passwordHelpBlock" class="form-text">
A senha deve ter conter 6 caracteres, números e caracter especial.
</div>
<label for="inputPassword5" class="form-label">Confirmar novo Password: </label>
<input type="password" name="txtComfirmNovotPassword" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
<div id="passwordHelpBlock" class="form-text">
    A senha deve ter conter 6 caracteres, números e caracter especial.
</div>
<br>
<button type="submit" name="novaSenha" class="btn btn-primary">Submit</button>
</form>
    </div>
    <div class="col">
    </div>
  </div>
</div>




    <script src="../node_modules/jquery/dist/jquery.min.js"></script> 
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php




?>