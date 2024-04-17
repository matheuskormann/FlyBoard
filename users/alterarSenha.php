<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit;
}

?>
<!DOCTYPE html>
    <html lang="pt-br">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="comfig.css">
        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
        <title>Document</title>
    </head>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="ToastRegex" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </html>
    
<?php

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
                        window.location.href = './comfig.php?result=successPasswordUpload';
                      </script>";
            } else {
                echo "<script>
                const ToastRegex = document.getElementById('ToastRegex')
                const toastBody = ToastRegex.querySelector('.toast-body');
            
                toastBody.textContent = 'Falha ao alterar senha, Tente novamente.';
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
                toastBootstrap.show()
                </script>";
            }
            $stmt->close();
        } else {
            echo "<script>
            const ToastRegex = document.getElementById('ToastRegex')
            const toastBody = ToastRegex.querySelector('.toast-body');
        
            toastBody.textContent = 'As Senhas Não Conferem.';
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
            toastBootstrap.show()
            </script>";
        }
    } else {
        echo "<script>
        const ToastRegex = document.getElementById('ToastRegex')
        const toastBody = ToastRegex.querySelector('.toast-body');
    
        toastBody.textContent = 'Senha atual incorreta.';
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
        toastBootstrap.show()
        </script>";
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
<form name="form1" method="post" onsubmit="return validateForm()">
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

<div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="ToastRegex" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>


    <script>
        function validateForm() {
            console.log("entrouteste")
            var passwordNew = document.forms["form1"]["txtNovotPassword"].value;

            var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;


            if(!passwordRegex.test(passwordNew)){
                const ToastRegex = document.getElementById('ToastRegex')
                const toastBody = ToastRegex.querySelector('.toast-body');

                toastBody.textContent = "Senha Inválida, A sua senha deve conter no Minímo 6 Caracteres, 1 Número e 1 Caracter Especial.";
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
                toastBootstrap.show()
                return false;
            }
            else {
                return true;}
            }
    </script>

    <script src="../node_modules/jquery/dist/jquery.min.js"></script> 
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
