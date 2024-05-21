<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit; 
}
else if ($_SESSION["role"] != "admin" && $_SESSION["role"] != "funcionario") {
    echo "<script>
            window.history.back();
          </script>";
    exit; 




}
            $id = $_GET["id"];
            $iduser = $_SESSION["id"];
            $sql = "SELECT  NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $id";
            $sqlNavBar = "SELECT NAME ,EMAIL , ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $iduser";
            $result = $conn->query($sql);
            $resultNavBar = $conn->query($sqlNavBar);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $name = $row["NAME"];
                    $cpf = $row["CPF"];
                    $login = $row["EMAIL"];
                    $dataNascimento = $row["DATA_DE_NASCIMENTO"];
                    $role = $row["ROLE"];
                    $userImagePath = $row["USERIMAGEPATH"];
                }
            $rowNavBar = $resultNavBar->fetch_assoc();
            }
            $id = $_SESSION["id"];
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./userLstStyle.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../imagens/flyboardLOGOremovido.ico" type="image/x-icon">

    <title>UserInfos</title>
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
                     <th scope="row">Nome:</th>
                     <td><?php echo $name ?></td>
                    </tr>
                    <tr>
                     <th scope="row">Cpf:</th>
                     <td><?php echo $cpf ?></td>
                    </tr>
                    <tr>
                     <th scope="row">Email:</th>
                     <td><?php echo $login ?></td>
                    </tr>
                    <tr>
                     <th scope="row">Data De Nascimento:</th>
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



