<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit; 
}
else if ($_SESSION["role"] == "admin") {
    echo "<script>
            window.location.href = '../index/index.html';
          </script>";
    exit; 
}
            $id = $_GET["id"];
            $sql = "SELECT  NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $name = $row["NAME"];
                    $cpf = $row["CPF"];
                    $login = $row["EMAIL"];
                    $dataNascimento = $row["DATA_DE_NASCIMENTO"];
                    $role = $row["ROLE"];
                    $userImagePath = $row["USERIMAGEPATH"];
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
        <a id="botaoVoltar" type="button" class="btn btn-light" href="./listUsers.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
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
                <h1>Dados:
                </h1>
                <div class="container">
                    <table class="table  table-borderless">
                    <tr>
                     <th scope="row">nome:</th>
                     <td><?php echo $name ?></td>
                    </tr>
                    <tr>
                     <th scope="row">cepeéfi:</th>
                     <td><?php echo $cpf ?></td>
                    </tr>
                    <tr>
                     <th scope="row">email:</th>
                     <td><?php echo $login ?></td>
                    </tr>
                    <tr>
                     <th scope="row">Data Nascimento:</th>
                     <td><?php echo $dataNascimento ?></td>
                    </tr>
                    <tr>
                     <th scope="row">Cargo:</th>
                     <td><?php echo $role ?></td>
                    </tr>
                      
    
    
    
    
    
    
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



