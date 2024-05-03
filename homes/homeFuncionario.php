<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit; 
} 
else if ($_SESSION["role"] != "admin" && $_SESSION["role"] != "funcionario") {
    echo "<script>
            alert('Você não tem permissão!');
            window.history.back();
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
  <title>Home</title>
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

</head>

<body>

  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index/index.php">
        <img src="../imagens/flyboardNavBar.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
        flyboard
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
            <li><a class="dropdown-item" href="../homes/homeAdmin.php">admin</a></li>
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
              <li><a class="dropdown-item" href="../admListVoos/addVoo.php">Add voo</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="../admListVoos/listVoos.php">List Voos</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Bagagem
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../adminBagagem/addBagemAdmin.php">cad.P Bagagem</a></li>
              <li><a class="dropdown-item" href="#">loc. Bagagem</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="../adminBagagem/listBagagens.php">List Bagagem</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Clientes
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../admListUser/listUsers.php">List Clientes</a></li>
              <!-- <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li> -->
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
            <li><a class="dropdown-item" href="../users/comfig.php">configurações</a></li>
            <li><a class="dropdown-item" onclick="logout()">logout</a></li>
          </ul>
        </li>
        </ul>
      </div>
    </div>
  </nav>
  <img src="../imagens/imgHomeFuncionaros.png" class="d-block w-100" alt="...">





  <script>
    function logout() {
      if (confirm('Tem certeza que deseja fazer logout?')) {
        window.location.href = '../users/logout.php';
      }
    }
  </script>
  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>