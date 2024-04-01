<?php
include('../connections/connection.php');
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css"> 
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
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
      </ul  class="nav-item d-flex list-unstyled">
        <li class="nav-item-no-marker">
      <?php
      if (!isset($_SESSION["id"])) {
        echo'<a class="nav-link"  href="../login/login.html">Login</a>';
      }
      else{
        $id = $_SESSION["id"];
        $sql = "SELECT name FROM users WHERE id_user = $id";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo'<a class="nav-link" href="../homes/collectorHomes.php">' . $row["name"] . "</a>";
      }
      ?>
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


  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
