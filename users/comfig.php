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

$id = $_SESSION["id"];
$sql = "SELECT NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name = $row["NAME"];
        $cpf = $row["CPF"];
        $login = $row["EMAIL"];
        $datanascimento = $row["DATA_DE_NASCIMENTO"];
        $role = $row["ROLE"];
        $atualUserImagePath = $row["USERIMAGEPATH"];
    }
}

if (isset($_POST['upload'])) {
    if (isset($_FILES['userImg'])) {
        $userImg = $_FILES['userImg'];
        if ($userImg['size'] > 2197152) {
            echo "<script>alert('Arquivo muito grande!');</script>";
        } else {
            if (file_exists($atualUserImagePath) && $atualUserImagePath != "../imagens/padraoUser.png") {
                if (!unlink($atualUserImagePath)) {
                    echo "<script>
                    const ToastRegex = document.getElementById('ToastRegex')
                    const toastBody = ToastRegex.querySelector('.toast-body');
                
                    toastBody.textContent = 'Falha ao atualizar a imagem, Tente novamente.';
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
                    toastBootstrap.show()
                    </script>";
                }
            }

            $pasta = "../imagens/upload/imagPesrfilUsers/";
            $nomeUserImg = $userImg['name'];
            $novoNomeUserImg = uniqid("userImg_". $name."-");
            $extensao = strtolower(pathinfo($nomeUserImg, PATHINFO_EXTENSION));
            $path = $pasta . $novoNomeUserImg . "." . $extensao;
            $deuCerto = move_uploaded_file($userImg["tmp_name"], $path);

            if ($deuCerto) {
                $sqlUploadImg = "UPDATE USERS SET USERIMAGEPATH = '$path' WHERE ID_USER = $id";
                $result = $conn->query($sqlUploadImg);
                echo "<script>
                window.location.href = './comfig.php?result=successImgUpload';
                </script>";
            }
        }
    }
}

if (isset($_POST['atualizarDados'])) {
    $name2 = $_POST["txtName"];
    $login2 = $_POST["txtlogin"];
    $id = $_SESSION["id"];
    $sql2 = "UPDATE USERS SET NAME = '$name2', EMAIL = '$login2' WHERE ID_USER = $id";
    $result2 = $conn->query($sql2);
    if ($result2 === TRUE) {
        echo "<script>
        window.location.href = './comfig.php?result=successDataUpdate';
              </script>";
    } else {
        echo "<script>
        const ToastRegex = document.getElementById('ToastRegex')
        const toastBody = ToastRegex.querySelector('.toast-body');
    
        toastBody.textContent = 'Falha ao atualizar o usuário, Tente novamente.';
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
        toastBootstrap.show()
        </script>";
    }
}
?>
<html>
<body>
    <div id="conteinerButtom">
        <a id="botaoVoltar" type="button" class="btn btn-light" href="../homes/collectorHomes.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Imagem</h1>
                <div class="">
                    <div>
                        <div id="comtImgUser">
                            <img height="175px" id="userImg" src="<?php echo $atualUserImagePath ?>" alt="">
                        </div>
                        <div>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Alterar imagem de perfil:</label>
                                    <input name="userImg" class="form-control" type="file" id="formFile">
                                </div>
                                <br>
                                <button name="upload" class="btn btn-primary mb-3" type="submit">Salvar imagem</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <h1>Dados</h1>
                <form action="" method="POST" >
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nome Completo:</label>
                        <input type="text"  name="txtName" class="form-control" id="exampleFormControlInput1" value="<?php echo $name ?>">
                    </div>      
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">E-mail:</label>
                        <input type="email" name="txtlogin" class="form-control" id="exampleFormControlInput1" value="<?php echo $login ?>">
                    </div>
                    <button name="atualizarDados" class="btn btn-primary mb-3" type="submit">Salvar</button>
                </form>
                <a href="../users/alterarSenha.php">Alterar Senha</a>
            </div>
        </div>
    </div>
    
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
if (isset($_GET["result"])) {
    $result = $_GET["result"];
    if ($result == "successDataUpdate") {
        echo "<script>
        const ToastRegex = document.getElementById('ToastRegex')
        const toastBody = ToastRegex.querySelector('.toast-body');
    
        toastBody.textContent = 'Dados atualizados com sucesso!';
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
        toastBootstrap.show()
        </script>";
    } else if ($result == "successImgUpload") {
        echo "<script>
        const ToastRegex = document.getElementById('ToastRegex')
        const toastBody = ToastRegex.querySelector('.toast-body');
    
        toastBody.textContent = 'Imagem atualizada com sucesso!';
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
        toastBootstrap.show()
        </script>";
    } else if ($result == "successPasswordUpload") {
        echo "<script>
        const ToastRegex = document.getElementById('ToastRegex')
        const toastBody = ToastRegex.querySelector('.toast-body');
    
        toastBody.textContent = 'Senha atualizada com sucesso!';
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
        toastBootstrap.show()
        </script>";
    }
}
?>