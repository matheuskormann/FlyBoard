<?php
    include('../connections/connection.php');

    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: ../login/login.html  ");
    }
    else if ($_SESSION["role"] == "funcionario"|| $_SESSION["role"] == "admin") {
?>
<script>
    alert("Você não tem permissão!");
    header("Location: ../index/index.html ");
</script>
<?php
    }

    $id = $_SESSION["id"];
    $sql = "SELECT name ,login , role FROM users WHERE id_user = $id";
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
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" >Funcionários</a>
        </li>
        <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Voos
              </a>
              <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">checkpoint Voo</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">cad.P Voo</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">List Voos</a></li>
              </ul>
            </li>
        <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Bagagem
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">checkpoint Bag.</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">cad.P Bagagem</a></li>
                <li><a class="dropdown-item" href="#">loc. Bagagem</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">List Bagagem</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Clientes
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">List Clientes</a></li>
                <!-- <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li> -->
              </ul>
            </li>
      </ul>
      </ul>
      <li class="nav-item dropdown  d-flex">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?php
                    echo $row['name']
                ?>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">configurações</a></li>
                <li><a class="dropdown-item" href="#">logout</a></li>
              </ul>
            </li>
      </ul>
    </div>
  </div>
</nav>






  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
