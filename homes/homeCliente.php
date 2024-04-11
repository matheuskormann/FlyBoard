<?php
include('../connections/connection.php');
session_start();
if (!isset($_SESSION["id"])) {
  header("Location: ../login/login.php ");
}

$id = $_SESSION["id"];
$sql = "SELECT NAME ,EMAIL , ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

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
            <a class="nav-link active" aria-current="page" href="#">Clientes</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Voos
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Meus Voos</a></li>
              <li><a class="dropdown-item" href="#">Novos Voos</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Buscar voos</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Bagagem
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Nova Bagagem</a></li>
              <li><a class="dropdown-item" href="#">Rastrear Bagagem</a></li>
            </ul>
          </li>
        </ul>
        <li class="nav-item dropdown  d-flex">
          <div id="comtImgUser">
            <img id="userImg" src="<?php echo $row['USERIMAGEPATH']  ?>" alt="">
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
  <div id="carouselExampleDark" class="carousel carousel-dark slide">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active" data-bs-interval="10000">
        <img src="../imagens/fotosHome1.png" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block text-white">
          <h5>FlyBoard</h5>
          <p>Seu destino começa aqui, nas asas da tecnologia.</p>
        </div>
      </div>
      <div class="carousel-item" data-bs-interval="2000">
        <img src="../imagens/fotosHome2.png" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block ">
          <h5>FlyBoard</h5>
          <p>Seu destino começa aqui, nas asas da tecnologia.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="../imagens/fotosHome3.png" class="d-block w-100" alt="...">
        <div class="carousel-caption d-none d-md-block ">
          <h5>FlyBoard</h5>
          <p>Seu destino começa aqui, nas asas da tecnologia.</p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <br>
  <br>
  <div class="container">
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
      <div class="col">
        <div class="card h-100">
          <img src="../imagens/fotoVeneza.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Veneza</h5>
            <p class="card-text">A capital da região de Vêneto, no norte da Itália, é formada por mais de 100 pequenas ilhas em uma lagoa no Mar Adriático. A cidade não tem estradas, apenas canais (como a via Grand Canal), repletos de palácios góticos e renascentistas.</p>
            <a href="#" class="btn btn-primary">Mais Detalhes</a>
          </div>
          <div class="card-footer">
            <span class="badge text-bg-secondary">19/03/24</span>
            <span class="badge text-bg-success">internacional</span>
            <span class="badge text-bg-warning">Noturno</span>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <img src="../imagens/fotoGrecia.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Atenas</h5>
            <p class="card-text">Atenas é a capital da Grécia. A cidade também foi o centro da Grécia Antiga, um império e civilização poderosos, e ainda é dominada por monumentos do século V a.C., como a Acrópole, uma cidadela no topo de uma montanha repleta de construções antigas.</p>
            <a href="#" class="btn btn-primary">Mais Detalhes</a>
          </div>
          <div class="card-footer">
            <span class="badge text-bg-info">Em andamento</span>
            <span class="badge text-bg-warning">Em transito</span>
            <span class="badge text-bg-danger">Bagagem frágeis</span>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <img src="../imagens/fotoMoscou .png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Moscou</h5>
            <p class="card-text">Moscou, situada às margens do rio de mesmo nome, no oeste da Rússia, é a capital cosmopolita do país. Em seu núcleo histórico está localizado o Kremlin, um complexo que abriga a residência do presidente e tesouros czaristas no Palácio do Arsenal.</p>
            <a href="#" class="btn btn-primary">Mais Detalhes</a>
          </div>
          <div class="card-footer">
            <span class="badge text-bg-dark">Concluído.</span>
            <br>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
          <img src="../imagens/fotoDubai.png" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Dubai</h5>
            <p class="card-text">Dubai é uma cidade e um emirado dos Emirados Árabes Unidos conhecida pelos shoppings de luxo, pela arquitetura ultramoderna e pela animada vida noturna. Burj Khalifa, uma torre de 830 metros de altura, domina a linha do horizonte repleta de arranha-céus.</p>
            <a href="#" class="btn btn-primary">Mais Detalhes</a>
          </div>
          <div class="card-footer">
            <span class="badge text-bg-dark">Concluído.</span>
            <br>
          </div>
        </div>
      </div>
    </div>
  </div>






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