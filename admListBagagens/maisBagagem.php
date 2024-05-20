<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit; 
}   
$iduser = $_SESSION["id"];
$sqlNavBar = "SELECT NAME ,EMAIL , ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $iduser";
$resultNavBar = $conn->query($sqlNavBar);
$rowNavBar = $resultNavBar->fetch_assoc();

$id = $_GET["id"];
$sql = "SELECT B.ID_BAGAGEM, B.CODIGO_BAGAGEM, B.PESO, B.TIPO, B.DESCRICAO, B.STATUS_BAGAGEM, 
               P.NOME_PASSAGEIRO, P.CPF_PASSAGEIRO, V.CODIGO_VOO, V.LOCAL_DE_ORIGEM, V.LOCAL_DE_DESTINO, 
               V.DATA_IDA, V.DATA_CHEGADA, V.PORTAO_EMBARQUE, V.AERONAVE, V.CODIGO_AERONAVE, 
               V.OPERADORA, V.VOOIMAGEMPATH
        FROM BAGAGENS B
        INNER JOIN PASSAGENS P ON B.FK_PASSAGENS_ID_PASSAGEM = P.ID_PASSAGEM
        INNER JOIN VOOS V ON P.FK_VOOS_ID_VOO = V.ID_VOO
        WHERE B.ID_BAGAGEM = $id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $CODIGO_BAGAGEM = $row["CODIGO_BAGAGEM"];
        $PESO = $row["PESO"];
        $TIPO = $row["TIPO"];
        $DESCRICAO = $row["DESCRICAO"];
        $STATUS_BAGAGEM = $row["STATUS_BAGAGEM"];
        $NOME_PASSAGEIRO = $row["NOME_PASSAGEIRO"];
        $CPF_PASSAGEIRO = $row["CPF_PASSAGEIRO"];
        $CODIGO_VOO = $row["CODIGO_VOO"];
        $ORIGEM = $row["LOCAL_DE_ORIGEM"];
        $DESTINO = $row["LOCAL_DE_DESTINO"];
        $DATA_IDA = $row["DATA_IDA"];
        $DATA_CHEGADA = $row["DATA_CHEGADA"];
        $PORTAO_EMBARQUE = $row["PORTAO_EMBARQUE"];
        $AERONAVE = $row["AERONAVE"];
        $OPERADORA = $row["OPERADORA"];
        $CODIGO_AERONAVE = $row["CODIGO_AERONAVE"];
        $VOOIMAGEMPATH = $row["VOOIMAGEMPATH"];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./comfig.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../imagens/flyboardLOGOremovido.ico" type="image/x-icon">
    <title><?php echo $CODIGO_BAGAGEM ?></title>
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

    <div id="conteinerButtom">
        <a id="botaoVoltar" type="button" class="btn btn-light" href="./listBagagens.php">
            <img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px">
        </a>
    </div>
    <script>
        // Função para voltar para a última tela
        function goBack() {
            window.history.back();
        }

        // Adiciona um event listener para o clique no botão
        document.getElementById("botaoVoltar").addEventListener("click", function(event) {
            event.preventDefault(); // Previne o comportamento padrão do link
            goBack(); // Chama a função para voltar
        });
    </script>
    <div class="container ">
  <div class="row align-items-start">
    <div class="col">
     
    </div>
    <div class="col-6">
      <h2>Codigo Bagagem: <?php echo $CODIGO_BAGAGEM ?></h2>
      <br>
      <H5>Informações do Voo:</H5>
      <p>Código Do Voo: <?php echo $CODIGO_VOO ?></p>
      <p>Destino: <?php echo $DESTINO ?></p>
      <p>Origem: <?php echo $ORIGEM ?></p>
   
      <h5>Informações Do Passageiro:</h5>
        <p>Nome: <?php echo $NOME_PASSAGEIRO ?></p>
        <p>CPF: <?php echo $CPF_PASSAGEIRO ?></p>
       
        <h5>Informações Da Bagagem:</h5>
        <p>Peso: <?php echo $PESO ?></p>
        <p>Tipo: <?php echo $TIPO ?></p>
        <p>Descricao: <?php echo $DESCRICAO ?></p>
        <div class="alert alert-secondary" role="alert">Status da Bagagem: <?php echo $STATUS_BAGAGEM ?></div>







    </div>
    <div class="col">
     
    </div>
  </div>
</div>
