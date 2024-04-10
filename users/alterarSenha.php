<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.html");
    exit; 
} 

if (isset($_POST['novaSenha'])) {
    $id = $_SESSION["id"];
    $sql = "SELECT PASSWORD FROM USERS WHERE ID_USER = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $password = $row["PASSWORD"];
        }
    }

    if($password == $_POST['txAntigotPassword'] ){
        if($_POST['txtNovotPassword']== $_POST['txtComfirmNovotPassword']){
            $passwordNovo = $_POST["txtNovotPassword"];
            $id = $_SESSION["id"];
            $sql2 = "UPDATE USERS SET PASSWORD = '$passwordNovo' WHERE ID_USER = $id";
            $result2 = $conn->query($sql2);
            if ($result2 === TRUE) {
                echo "<script>
                        alert('Password atualizado com sucesso!');
                        window.location.href = './comfig.php';
                      </script>";
            } 
            else {
                echo "<script>alert('Algo deu errado...');</script>";
            }
        }
        else{
            echo "<script>alert('As senhas não são iguais!');</script>";
        }

    }
    else{
        echo "<script>alert('Passowrd esta incoreto!');</script>";
    }
    

}


?><!DOCTYPE html>
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