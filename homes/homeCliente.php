
<?php
include('../connections/connection.php');
session_start();
if (!isset($_SESSION["id"])) {
  header("Location: ../login/login.php ");
}

$id = $_SESSION["id"];
$sql = "SELECT NAME , EMAIL, ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Consulta para buscar bagagens de um usuário específico e contar o número de bagagens para cada voo
$sql_bagagens = "SELECT B.ID_BAGAGEM, B.CODIGO_BAGAGEM, B.PESO, B.TIPO, B.DESCRICAO, P.NOME_PASSAGEIRO, V.LOCAL_DE_ORIGEM, V.LOCAL_DE_DESTINO, V.DATA_IDA, V.DATA_CHEGADA ,  V.PORTAO_EMBARQUE, V.VOOIMAGEMPATH, COUNT(*) as QTD_BAGAGENS
  FROM BAGAGENS B 
  INNER JOIN PASSAGENS P ON B.FK_PASSAGENS_ID_PASSAGEM = P.ID_PASSAGEM 
  INNER JOIN VOOS V ON P.FK_VOOS_ID_VOO = V.ID_VOO 
  WHERE P.FK_USERS_ID_USER = $id
  GROUP BY B.ID_BAGAGEM, B.CODIGO_BAGAGEM, B.PESO, B.TIPO, P.NOME_PASSAGEIRO, V.LOCAL_DE_ORIGEM, V.LOCAL_DE_DESTINO, V.DATA_IDA, V.DATA_CHEGADA ,  V.PORTAO_EMBARQUE, V.VOOIMAGEMPATH
  ORDER BY V.DATA_IDA DESC";
$result_bagagens = $conn->query($sql_bagagens);

// Consulta para buscar todas as viagens de um usuário específico e contar o número de passagens para cada voo
$sql_viagens = "SELECT VOOS.*, GROUP_CONCAT(PASSAGENS.ID_PASSAGEM) AS passagens_ids, COUNT(PASSAGENS.ID_PASSAGEM) AS numero_passagens
FROM PASSAGENS
INNER JOIN VOOS ON PASSAGENS.FK_VOOS_ID_VOO = VOOS.ID_VOO
WHERE PASSAGENS.FK_USERS_ID_USER = $id
GROUP BY VOOS.ID_VOO
ORDER BY VOOS.DATA_IDA DESC";
$result_viagens = $conn->query($sql_viagens);


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
        <?php
        if ($row['ROLE'] == 'admin') {
          ?>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            clientes
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../homes/homeFuncionario.php">funcionario</a></li>
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
              Passagens
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../passagem/addPasagemCliente.php">Adicionar passagem</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Ver minhas passagens</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Bagagem
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../Bagagem/addBagemCliente.php">Nova Bagagem</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
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
            <li><a class="dropdown-item" href="../users/comfig.php">Configurações</a></li>
            <li><a class="dropdown-item" onclick="showModal()">Sair</a></li>
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
  <div class="container">
    <h4>Minhas Bagagens:</h4>
    <div class="position-relative">
        <div class="position-absolute bottom-0 end-0">
            <a href="../Bagagem/addBagemCliente.php" class="btn btn-success buttomAdd" style="border-radius: 85px;">
                <img src="../imagens/mais.png" alt="">
            </a>
        </div>
    </div>
    <br>
    <div class="boxcardCliente">
        <?php
        if ($result_bagagens->num_rows > 0) {
            // Exibe os dados das bagagens
            while ($row = $result_bagagens->fetch_assoc()) {
                ?>
                <div class="col">
                    <div class="card h-100 cardCliente">
                        <div class="card-body">
                            <h5 class="card-title"><img src="../imagens/mala-alt.png" alt="editar" style="width: 19px; height: 19px; position: relative; bottom: 2px;"> <?php echo $row["CODIGO_BAGAGEM"]; ?></h5>
                            <p class="card-text">TIPO: <?php echo $row["TIPO"]; ?><br>PESO: <?php echo $row["PESO"]; ?><br>
                                DESCRIÇÃO: <?php echo $row["DESCRICAO"]; ?><br></p>
                        </div>
                        <div class="card-footer">
                          <!-- Botão "Mais Detalhes" que abre o modal -->
                          <a type="button" class="btn btn-primary" href='../admListBagagens/maisBagagem.php?id=<?php echo $row["ID_BAGAGEM"]; ?>'>Mais Detalhes </a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="alert alert-warning" role="alert">
                Nenhuma bagagem encontrada para este usuário.
            </div>
            <?php
        }
        ?>
    </div>
</div>



  <!-- Modal para exibir as informações da bagagem -->
  <div class="modal fade" id="bagagemModal" tabindex="-1" role="dialog" aria-labelledby="bagagemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bagagemModalLabel">Detalhes da Bagagem</h5>
        </div>
        <div class="modal-body" id="bagagemInfo">
          <!-- Aqui serão exibidas as informações da bagagem -->
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">fechar</button>
        </div>
      </div>
    </div>
  </div>


  
  <!-- Função JavaScript para abrir o modal e carregar as informações da bagagem -->
  <script>
            function abrirModalBagagem(codigoBagagem) {
                $.ajax({
                    url: '../sistem/getBagagemInfo.php', // O arquivo PHP que irá processar a requisição e retornar as informações da bagagem
                    type: 'GET',
                    data: {codigoBagagem: codigoBagagem}, // Passa o código da bagagem para o arquivo PHP
                    dataType: 'json',
                    success: function(response) {
                        // Preenche o modal com as informações da bagagem
                        var modalContent = '';
                        modalContent += '<p>Código da Bagagem: ' + response.bagagem.CODIGO_BAGAGEM + '</p>';
                        modalContent += '<p>Descrição: ' + response.bagagem.DESCRICAO + '</p>';
                        modalContent += '<p>Peso: ' + response.bagagem.PESO + '</p>';
                        modalContent += '<p>Nome do Passageiro: ' + response.passagem.NOME_PASSAGEIRO + '</p>';
                        modalContent += '<p>CPF do Passageiro: ' + response.passagem.CPF_PASSAGEIRO + '</p>';
                        modalContent += '<div class="alert alert-secondary" role="alert">Status da Bagagem: ' + response.bagagem.STATUS_BAGAGEM + '</div>';
                        $('#bagagemInfo').html(modalContent);
                        $('#bagagemModal').modal('show'); // Abre o modal
                    },
                    error: function(xhr, status, error) {
                        alert('Erro na requisição AJAX: ' + error);
                    }
                });
            }
        </script>


  <hr>
  <br>
  <div class="container">
    <h4>Meus voos:</h4>
    <div class="position-relative">
        <div class="position-absolute bottom-0 end-0">
          <a href="../passagem/addPasagemCliente.php" class="btn btn-success buttomAdd" style="border-radius: 85px;">
             <img src="../imagens/mais.png" alt="">
          </a>
        </div>
    </div>
    <br>
    <div class="boxcardCliente">
      <?php
      if ($result_viagens->num_rows > 0) {
        while($row = $result_viagens->fetch_assoc()) {
          ?>
          <div class="col espasso">
          <div class="card h-100 cardCliente ">
            <img src="<?php echo $row["VOOIMAGEMPATH"]; ?>" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><?php echo $row["LOCAL_DE_DESTINO"]; ?></h5>
              <p class="card-text">Data de saida:<br><?php echo $row["DATA_IDA"];?><br><br>Portão:<br><?php echo $row["PORTAO_EMBARQUE"];?></p>
              <a href="../passagem/detalesPasagem.php?idVoo=<?php echo $row['ID_VOO']; ?>" class="btn btn-primary">Mais Detalhes</a>
            </div>
            <div class="card-footer">
            <?php
            $status_viagem = verificarStatusViagem($row["DATA_IDA"]);
            ?>
              <br>
              <?php 
              $id_passagem = (int) $row["passagens_ids"];
              // Query para contar a quantidade de passagens com o mesmo FK_USERS_ID_VOO
              $sql = "SELECT COUNT(*) AS quantidade_passagens
                      FROM PASSAGENS
                      WHERE FK_VOOS_ID_VOO = (
                          SELECT FK_VOOS_ID_VOO
                          FROM PASSAGENS
                          WHERE ID_PASSAGEM = $id_passagem
                      )";
              
              $result = $conn->query($sql);
              
              if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    '.$row["quantidade_passagens"].'
                    <span class="visually-hidden">passagens para o mesmo voo</span>
                    </span>';
              } else {  
                echo "Nenhuma passagem encontrada para o ID especificado.";
              }
              ?>
            </div>
          </div>
          </div>
          <?php
        }
      }
   
      else {
        ?>
        <div class="alert alert-warning" role="alert">
          Nenhuma viagem encontrada para este usuário.
        </div>
        <?php
      }
   ?>
    </div>
  </div>

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
  <?php
 function verificarStatusViagem($data_ida) {
          $data_atual = date('Y-m-d');
          $data_ida = date('Y-m-d', strtotime($data_ida));

          if ($data_ida > $data_atual) {
            $diferenca = strtotime($data_ida) - strtotime($data_atual);
            $dias = floor($diferenca / (60 * 60 * 24));

            echo '<span class="badge rounded-pill text-bg-primary">Faltam ' . $dias . ' dias para a viagem.</span>';
                
          } else if ($data_ida == $data_atual) {
            echo '<span class="badge rounded-pill text-bg-success">Em Andamento</span>';
          } else {
            echo '<span class="badge rounded-pill text-bg-warning">Ja Realivada</span>';
          }
        }
        ?>

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
