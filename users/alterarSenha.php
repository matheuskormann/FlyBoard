<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit;
}
$iduser = $_SESSION["id"];
$sqlNavBar = "SELECT NAME ,EMAIL , ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $iduser";
$resultNavBar = $conn->query($sqlNavBar);
$rowNavBar = $resultNavBar->fetch_assoc();

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
<nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index/index.php">
          <img src="../imagens/flyboardNavBar.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
          FlyBoard
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page"></a>
            </li>
          </ul>
          <li class="nav-item dropdown  d-flex">
            <div id="comtImgUserNav">
              <img id="userImgNav" src="<?php echo $rowNavBar['USERIMAGEPATH'] ?>" alt="">
            </div>
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php
              echo $rowNavBar['NAME']
              ?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" onclick="showModal()">Sair</a></li>
            </ul>
          </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="labelHeader" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5>Tem certeza que deseja sair do sistema?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" onclick="sair()">Sim, sair</button>
                    </div>
                </div>
            </div>
        </div>
       


  <script>
    function showModal() {
      $('#modal').modal('show');
    }
    function sair() {
      window.location.href = '../users/logout.php';
    }
  </script>
    <a id="botaoVoltar" type="button" class="btn btn-light" href="./comfig.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
 
<div class="container">
  <div class="row">
    <div class="col">
    </div>
    <div class="col">
    <label for="inputPassword5" class="form-label">Senha Atual:</label>
<input type="password" name="txAntigotPassword" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock">
<br>
<hr>
<br>
<form name="form1" method="post" onsubmit="return validateForm()">
<label for="inputPassword5" class="form-label">Nova Senha: </label>
<input type="password" name="txtNovotPassword" id="inputPassword5"  onsubmit="return validateForm()" class="form-control" aria-describedby="passwordHelpBlock">
<div id="passwordHelpBlock" class="form-text">
A senha deve ter conter 6 caracteres, números e caracter especial.
</div>
<label for="inputPassword5" class="form-label">Confirmar nova Senha: </label>
<input type="password" name="txtComfirmNovotPassword" id="inputPassword5"   onsubmit="return validateForm()" class="form-control" aria-describedby="passwordHelpBlock">
<div id="passwordHelpBlock" class="form-text">
    A senha deve ter conter 6 caracteres, números e caracter especial.
</div>
<br>
<button type="submit" name="novaSenha" class="btn btn-primary">Enviar</button>
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
                return true;
            }
            }
    </script>


</body>
</html>
