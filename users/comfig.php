<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.html");
    exit; 
} 

$id = $_SESSION["id"];
$sql = "SELECT name, cpf, login, data_de_nacimento, role, userImagePath FROM users WHERE id_user = $id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name = $row["name"];
        $cpf = $row["cpf"];
        $login = $row["login"];
        $datanascimento = $row["data_de_nacimento"];
        $role = $row["role"];
        $atualUserImagePath = $row["userImagePath"];
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
                    echo "<script>alert('Não foi possível excluir sua antiga imagem');</script>";
                }
            }

            $pasta = "../imagens/upload/imagPesrfilUsers/";
            $nomeUserImg = $userImg['name'];
            $novoNomeUserImg = uniqid("userImg_". $name."-");
            $extensao = strtolower(pathinfo($nomeUserImg, PATHINFO_EXTENSION));
            $path = $pasta . $novoNomeUserImg . "." . $extensao;
            $deuCerto = move_uploaded_file($userImg["tmp_name"], $path);

            if ($deuCerto) {
                $sqlUploadImg = "UPDATE users SET userImagePath = '$path' WHERE id_user = $id";
                $result = $conn->query($sqlUploadImg);
                echo "<script>alert('Arquivo enviado com sucesso!!');</script>";
            }
        }
    }
}

if (isset($_POST['atualizarDados'])) {
    $name2 = $_POST["txtName"];
    $login2 = $_POST["txtlogin"];
    $id = $_SESSION["id"];
    $sql2 = "UPDATE users SET name = '$name2', login = '$login2' WHERE id_user = $id";
    $result2 = $conn->query($sql2);
    if ($result2 === TRUE) {
        echo "<script>
                alert('Usuário atualizado com sucesso!!!');
                window.location.href = './comfig.php';
              </script>";
    } else {
        echo "<script>alert('Algo deu errado...');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="comfig.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
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
