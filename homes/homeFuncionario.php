<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit; 
} 
else if ($_SESSION["role"] != "admin" && $_SESSION["role"] != "funcionario") {
    echo "<script>
            location.href = '../homes/collectorHomes.php?result=semPermissao';
          </script>";
    exit; 
}

$id = $_SESSION["id"];
$sql = "SELECT NAME ,EMAIL , ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
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
<body>

  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index/index.php">
        <img src="../imagens/flyboardNavBar.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
        Flyboard
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <?php
        if ($row['ROLE'] == 'admin') {
          ?>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Funcionarios
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../homes/homeCliente.php">Cliente</a></li>
            <li><a class="dropdown-item" href="../homes/homeAdmin.php">Administrador</a></li>
          </ul>
        </li>
          <?php
        }
        else{
          ?>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Clientes</a>
          </li>
          <?php
        }
        ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Voos
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../admListVoos/addVoo.php">Adicionar Voo</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="../admListVoos/listVoos.php">Lista De Voos</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Bagagem
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../admListBagagens/addBagemAdmin.php">Cadastro De Bagagem</a></li>
              <li><a class="dropdown-item" href="../locBagagem/LocBagagem.php">Localizar Bagagem</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="../admListBagagens/listBagagens.php">Lista De Bagagens</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Clientes
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../admListUser/listUsers.php">Lista De Clientes</a></li>
              <!-- <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li> -->
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Passagens
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../admListPassagens/listPassagem.php">Lista De Passagens</a></li>
            </ul>
          </li>
        </ul>
        </ul>
        <li class="nav-item dropdown  d-flex">
          <div id="comtImgUser">
            <img id="userImg" src="<?php echo $row['USERIMAGEPATH'] ?>" alt="">
          </div>
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <?php echo $row['NAME'] ?> </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../users/comfig.php">Configurações</a></li>
            <li><a class="dropdown-item" onclick="showModal()">Sair</a></li>
          </ul>
        </li>
        </ul>
      </div>
    </div>
  </nav>
  <img src="../imagens/imgHomeFuncionaros.png" class="d-block w-100" alt="...">



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
  <br>

  <div class="container">
    <div class="card text-center">
      <div class="card-header">
        Localizar Bagagens
      </div>
      <div class="card-body">
        <h5 class="card-title"></h5>
        <p class="card-text"></p>
        <a href="../locBagagem/LocBagagem.php" class="btn btn-primary">Ir para o localizador</a>
      </div>
    </div>
  </div>
  <br>
  <div class="container ">
    <div class="row row-cols-1 row-cols-md-2 g-4">
      <div class="col">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Adicionar Voo</h5>
            <p class="card-text">Adicionar um novo Voo.</p>
          </div>
          <div class="card-footer">
          <a href="../admListVoos/addVoo.php" class="btn btn-primary">ADICIONAR</a>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Adicionar Passagem</h5>
            <p class="card-text">Adicionar uma nova pasagem a um usuario.</p>
          </div>
          <div class="card-footer">
          <a href="../admListPassagens/addPassagemAdm.php" class="btn btn-primary">ADICIONAR</a>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Adicionar Bagagem</h5>
            <p class="card-text">Adicionar uma nova Bagagem a um usuario.</p>
          </div>
          <div class="card-footer">
          <a href="../admListBagagens/addBagemAdmin.php" class="btn btn-primary">ADICIONAR</a>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title">Info. Cliente</h5>
            <p class="card-text">Acesar informasois dos clientes</p>
          </div>
          <div class="card-footer">
          <a href="../admListUser/listUsers.php" class="btn btn-primary">IR PARA</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br>
  <br>
  <br>








  <script>
  function showModal() {
      $('#modal').modal('show');
    }
    function sair() {
      window.location.href = '../users/logout.php';
    }
  </script>   
  <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="semPermissao" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          Você não tem permissão para isso! 
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>
  <?php
      if (isset($_GET["result"])) {
          $result = $_GET["result"];
          if ($result == 'semPermissao') {
            echo "<script>
            const semPermissao = document.getElementById('semPermissao')
    
            const Bootstrap = bootstrap.Toast.getOrCreateInstance(semPermissao)
            Bootstrap.show()
                  </script>";
        }
        else if($result == "erro") {
            echo "<script>
            const ToastRegex = document.getElementById('ToastRegex')
            const toastBody = ToastRegex.querySelector('.toast-body');
            toastBody.textContent = 'algo deu errado!';
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
            toastBootstrap.show()
            </script>";
        } 
      }

      ?>
 
</body>

</html>