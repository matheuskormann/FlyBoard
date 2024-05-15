<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
  header("Location: ../login/login.php  ");
}
else if ($_SESSION["role"] != "admin") {
    echo "<script>
            location.href = '../homes/collectorHomes.php?result=semPermissao';
          </script>";
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
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../imagens/flyboardLOGOremovido.ico" type="image/x-icon">
    <title>Home</title>
</head>
<body>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    
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
          <div id="comtImgUser">
            <img id="userImg" src="<?php echo $rowNavBar['USERIMAGEPATH'] ?>" alt="">
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
