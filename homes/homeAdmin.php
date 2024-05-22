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

$id = $_SESSION["id"];
$sqlNavBar = "SELECT NAME ,EMAIL , ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $id";
$resultNavBar = $conn->query($sqlNavBar);
$rowNavBar = $resultNavBar->fetch_assoc();



// Número de usuários
$sql_num_users = "SELECT COUNT(*) AS total FROM users";
$result_num_users = $conn->query($sql_num_users);
$row_num_users = $result_num_users->fetch_assoc();
$total_users = $row_num_users['total'];

// Número de usuários para cada função
$sql_count_roles = "SELECT ROLE, COUNT(*) AS total_users FROM USERS GROUP BY ROLE";
$result_count_roles = $conn->query($sql_count_roles);

// Inicialize um array para armazenar o número de usuários para cada função
$roles_count = array();

// Verifique se a consulta retornou algum resultado
if ($result_count_roles->num_rows > 0) {
    // Loop pelos resultados da consulta
    while ($row = $result_count_roles->fetch_assoc()) {
        // Armazene o número de usuários para cada função em um array associativo
        $roles_count[$row['ROLE']] = $row['total_users'];
    }
}



 // Supondo que $data_atual contenha a data atual no formato YYYY-MM-DD
$data_atual = date("Y-m-d");
$sql_count_voos_dia = "SELECT COUNT(*) AS total_voos_dia FROM VOOS WHERE DATA_IDA = '$data_atual'";
$result_count_voos_dia = $conn->query($sql_count_voos_dia);
$row_count_voos_dia = $result_count_voos_dia->fetch_assoc();
$total_voos_dia = $row_count_voos_dia['total_voos_dia'];

// Número de voos
$sql_count_total_voos = "SELECT COUNT(*) AS total_voos FROM VOOS";
$result_count_total_voos = $conn->query($sql_count_total_voos);
$row_count_total_voos = $result_count_total_voos->fetch_assoc();
$total_voos = $row_count_total_voos['total_voos'];

// Número de passagens
$sql_count_passagens = "SELECT COUNT(*) AS total_passagens FROM PASSAGENS";
$result_count_passagens = $conn->query($sql_count_passagens);
$row_count_passagens = $result_count_passagens->fetch_assoc();
$total_passagens = $row_count_passagens['total_passagens'];

// Número de passageiros em cada classe
$sql_count_passageiros_por_classe = "SELECT CLASSE, COUNT(*) AS total_passageiros FROM PASSAGENS GROUP BY CLASSE";
$result_count_passageiros_por_classe = $conn->query($sql_count_passageiros_por_classe);

// Inicialize um array para armazenar o número de passageiros em cada classe
$passageiros_por_classe = array();

// Verifique se a consulta retornou algum resultado
if ($result_count_passageiros_por_classe->num_rows > 0) {
    // Loop pelos resultados da consulta
    while ($row = $result_count_passageiros_por_classe->fetch_assoc()) {
        // Armazene o número de passageiros em cada classe em um array associativo
        $passageiros_por_classe[$row['CLASSE']] = $row['total_passageiros'];
    }
}
// Número de bagagens
$sql_count_bagagens = "SELECT COUNT(*) AS total_bagagens FROM BAGAGENS";
$result_count_bagagens = $conn->query($sql_count_bagagens);
$row_count_bagagens = $result_count_bagagens->fetch_assoc();
$total_bagagens = $row_count_bagagens['total_bagagens'];

// Número de bagagens
$sql_count_tipos_bagagem = "SELECT TIPO, COUNT(*) AS total_por_tipo FROM BAGAGENS GROUP BY TIPO";
$result_count_tipos_bagagem = $conn->query($sql_count_tipos_bagagem);

// Inicialize um array para armazenar o número de bagagens de cada tipo
$bagagens_por_tipo = array();

// Verifique se a consulta retornou algum resultado
if ($result_count_tipos_bagagem->num_rows > 0) {
    // Loop pelos resultados da consulta
    while ($row = $result_count_tipos_bagagem->fetch_assoc()) {
        // Armazene o número de bagagens de cada tipo em um array associativo
        $bagagens_por_tipo[$row['TIPO']] = $row['total_por_tipo'];
    }
}

$sql_count_status_bagagem = "SELECT STATUS_BAGAGEM, COUNT(*) AS total_por_status FROM BAGAGENS GROUP BY STATUS_BAGAGEM";
$result_count_status_bagagem = $conn->query($sql_count_status_bagagem);

// Inicialize um array para armazenar o número de bagagens para cada status
$bagagens_por_status = array();

// Verifique se a consulta retornou algum resultado
if ($result_count_status_bagagem->num_rows > 0) {
    // Loop pelos resultados da consulta
    while ($row = $result_count_status_bagagem->fetch_assoc()) {
        // Armazene o número de bagagens para cada status em um array associativo
        $bagagens_por_status[$row['STATUS_BAGAGEM']] = $row['total_por_status'];
    }
}




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
        FlyBoard
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page">Administrador</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Usuários
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../admListUser/listUsers.php">Lista De Usuários</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="./homeCliente.php">Página Inicial</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Funcionários
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../funcionarios/cadFuncionario.php">Cadastro Funcionarios</a></li>
              <li><a class="dropdown-item" href="http://localhost/flyboard/admListUser/listUsers.php?filtro=2">Lista De Funcionarios</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="./homeFuncionario.php">Página Inicial</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Listas
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../admListVoos/listVoos.php">list Voos</a></li>
              <li><a class="dropdown-item" href="../admListPassagens/listPassagem.php">list Passagem</a></li>
              <li><a class="dropdown-item" href="../admListBagagens/listBagagens.php">list Bagagens</a></li>
            </ul>
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
            <li><a class="dropdown-item" href="../users/comfig.php">Configurações</a></li>
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
    <img src="../imagens/imgHomeAdmin.png" class="d-block w-100" alt="...">
  <br>
  <br>   

  <div class="container ">
    <div class="row row-cols-1 row-cols-md-2 g-4">
      <div class="col">
        <div class="card h-100">
        <h5 class="card-header">Usuarios</h5>
          <div class="card-body">
            <h5 class="card-title">Total de usuarios: <?php echo $total_users; ?></h5>
            <p class="card-text">Total de Clientes: <?php echo ($roles_count['cliente'] ?? 0); ?><br>Total de Funcionario: <?php echo ($roles_count['funcionario'] ?? 0); ?><br>Total de Administradores: <?php echo ($roles_count['admin'] ?? 0); ?> </p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
        <h5 class="card-header">Voos</h5>
          <div class="card-body">
            <h5 class="card-title">Total de Voos: <?php echo $total_voos; ?></h5>
            <p class="card-text">Voos programads para hoje: <?php echo $total_voos_dia; ?></p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
        <h5 class="card-header">Passagens</h5>
          <div class="card-body">
          <h5 class="card-title">Total de Passagens cadastrada: <?php echo $total_passagens; ?></h5>
            <p class="card-text">Classe executiva: <?php echo ($passageiros_por_classe['Econômica'] ?? 0); ?><br>Classe executiva Plus: <?php echo ($passageiros_por_classe['Econômica Plus'] ?? 0); ?><br>Class Executiva: <?php echo ($passageiros_por_classe['Executiva'] ?? 0); ?><br>Primeira class: <?php echo ($passageiros_por_classe['Primeira class'] ?? 0); ?></p>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card h-100">
        <h5 class="card-header">Bagagens</h5>
          <div class="card-body">
            <h5 class="card-title">Total de Bagagens cadastrada: <?php echo $total_bagagens; ?></h5>
            <p class="card-text">
                Quantidade total de bagagens: <?php echo $total_bagagens; ?><br>
                Bagagem de mão: <?php echo ($bagagens_por_tipo['Bagagem de mão'] ?? 0); ?><br>
                Bagagem despachada: <?php echo ($bagagens_por_tipo['Bagagem despachada'] ?? 0); ?><br>
                Bagagem despachada frágil: <?php echo ($bagagens_por_tipo['Bagagem despachada fragil'] ?? 0); ?><br>
                Bagagem especial: <?php echo ($bagagens_por_tipo['Bagagem especial'] ?? 0); ?><br>
                Bagagem de valor: <?php echo ($bagagens_por_tipo['Bagagem de valor'] ?? 0); ?><br>
                Carga: <?php echo ($bagagens_por_tipo['Carga'] ?? 0); ?><br>
                Carga Viva: <?php echo ($bagagens_por_tipo['Carga Viva'] ?? 0); ?><br>
            </p>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  <br><br>
  
  <div class="container">
    <div class="card text-center">
      <div class="card-header">
        Localizador de bagagem
      </div>
      <div class="card-body">
        <div class="container">
          <div class="row align-items-start">
            <div class="col">
            <p class="text-left">
                Quantidade total de bagagens: <?php echo $total_bagagens; ?><br>
                Bagagem de mão: <?php echo ($bagagens_por_status['Bagagem de mão'] ?? 0); ?><br>
                Bagagem despachada: <?php echo ($bagagens_por_status['Bagagem despachada'] ?? 0); ?><br>
                Bagagem despachada frágil: <?php echo ($bagagens_por_status['Bagagem despachada fragil'] ?? 0); ?><br>
            </p>
            </div>
            <div class="col">
            <p class="text-left">
                Bagagem especial: <?php echo ($bagagens_por_status['Bagagem especial'] ?? 0); ?><br>
                Bagagem de valor: <?php echo ($bagagens_por_status['Bagagem de valor'] ?? 0); ?><br>
                Carga: <?php echo ($bagagens_por_status['Carga'] ?? 0); ?><br>
                Carga Viva: <?php echo ($bagagens_por_status['Carga Viva'] ?? 0); ?><br>
            </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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

  <?php
      if (isset($_GET["result"])) {
          $result = $_GET["result"];
          if($result == "erro") {
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