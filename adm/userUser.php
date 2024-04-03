<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.html");
    exit; 
}
else if ($_SESSION["role"] == "admin") {
    echo "<script>
            alert('Você não tem permissão!');
            window.location.href = '../index/index.html';
          </script>";
    exit; 
}
            $id = $_GET["id"];
            $sql = "SELECT  name, cpf, login, data_de_nacimento, role, userImagePath FROM users WHERE id_user = $id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $name = $row["name"];
                    $cpf = $row["cpf"];
                    $login = $row["login"];
                    $dataNascimento = $row["data_de_nacimento"];
                    $role = $row["role"];
                    $userImagePath = $row["userImagePath"];
                }
            }
        ?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./userLstStyle.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <div id="conteinerButtom">
        <a id="botaoVoltar" type="button" class="btn btn-light" href="../adm/listUsers.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Imagem:</h1>
                <div class="">
                        <div id="comtImgUser">
                            <img height="175px" id="userImg" src="<?php echo $userImagePath ?>" alt="">
                        </div>
                </div>
            </div>
            <div class="col">
                <h1>Dados</h1>
            
            </div>
        </div>
    </div>
    
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


