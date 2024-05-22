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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">

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
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
        </ul class="nav-item d-flex list-unstyled">
        <li class="av-item dropdown  d-flex">
<?php
          if (!isset($_SESSION["id"])) {
            echo '<a class="nav-link"  href="../login/login.php">Login</a>';
          } else {
            $id = $_SESSION["id"];
            $sql = "SELECT NAME, USERIMAGEPATH FROM USERS WHERE ID_USER = $id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo '
        <div id="comtImgUser">
           <img id="userImg" src="' . $row["USERIMAGEPATH"] . '" alt="">
        </div>
        <a class="nav-link" href="../homes/collectorHomes.php">' . $row["NAME"] . '</a>';
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

  <div class="container">
      <div class="card mb-3">
        <div class="row g-0">
          <div class="col-lg-4">
            <img src="../imagens/imagemVoosindex.jpeg" class="img-fluid rounded-start" alt="..." style="max-width: 350px; height: 100%;">
          </div>  
          <div class="col-md-8">
            <div class="card-body coardPassagem" >
              <h5 class="card-title">Voos</h5>
              <p class="card-text">Bem-vindo ao nosso site! Aqui, estamos empenhados em tornar sua experiência de viagem aérea o mais tranquila e agradável possível. Com nossa plataforma intuitiva, você pode facilmente encontrar e reservar voos para destinos em todo o mundo. Quer seja uma viagem de negócios ou uma escapadela de lazer, oferecemos uma ampla gama de opções de voos para atender às suas necessidades. Além disso, mantemos você informado sobre horários de partida e chegada, atrasos e cancelamentos, garantindo que você esteja sempre um passo à frente em sua jornada.</p>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="container">
      <div class="card mb-3">
        <div class="row g-0">
          <div class="col-lg-4">
            <img src="../imagens/imagemPassagemIndex.jpeg" class="img-fluid rounded-start" alt="..."style="max-width: 350px; height: 100%;">
          </div>
          <div class="col-md-8">
            <div class="card-body coardPassagem" >
              <h5 class="card-title">Passagens</h5>
              <p class="card-text">Está pronto para embarcar em sua próxima aventura? Aqui, tornamos a compra de passagens aéreas uma experiência simples e sem complicações. Nossa plataforma oferece uma variedade de opções de tarifas e horários para que você possa encontrar a melhor oferta para o seu bolso e seu cronograma. Além disso, nosso sistema de reserva seguro garante que suas informações pessoais estejam protegidas. Reserve hoje mesmo e comece a contar os dias para sua próxima viagem inesquecível!

</p>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="container">
      <div class="card mb-3">
        <div class="row g-0">
          <div class="col-lg-4">
            <img src="../imagens/imagem2Bagagemindex.jpeg" class="img-fluid rounded-start" alt="..." style="max-width: 350px; height: 100%;">
          </div>
          <div class="col-md-8">
            <div class="card-body coardPassagem" >
              <h5 class="card-title">Bagagens</h5>
              <p class="card-text">Não se preocupe mais com bagagens perdidas! Com nosso serviço de rastreamento de bagagens, garantimos que sua bagagem esteja sempre ao seu alcance, desde o momento do check-in até a sua chegada ao destino. Nossa tecnologia avançada permite que você acompanhe o status da sua bagagem em tempo real, proporcionando tranquilidade durante toda a viagem. Além disso, oferecemos dicas úteis sobre como embalar de forma eficiente e o que levar em sua bagagem de mão para uma experiência de viagem sem estresse. Viaje com confiança, sabendo que suas bagagens estão em boas mãos!</p>
            </div>
          </div>
        </div>
      </div>
  </div>


  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>