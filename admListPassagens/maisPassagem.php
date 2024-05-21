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
$iduser = $_SESSION["id"];
$sqlNavBar = "SELECT NAME ,EMAIL , ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $iduser";
$resultNavBar = $conn->query($sqlNavBar);
$rowNavBar = $resultNavBar->fetch_assoc();
?><!DOCTYPE html>
<html lang="pt-br"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="comfig.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../imagens/flyboardLOGOremovido.ico" type="image/x-icon">

    <title>edir Passagem</title>
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

<?php
$id = $_GET["id"];  
$sql = "SELECT p.*, v.*
        FROM PASSAGENS p
        INNER JOIN VOOS v ON FK_VOOS_ID_VOO = v.ID_VOO
        WHERE p.ID_PASSAGEM =  $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $ID_PASSAGEM = $row["ID_PASSAGEM"];
        $CODIGO_PASSAGEM = $row["CODIGO_PASSAGEM"];
        $NOME_PASSAGEIRO = $row["NOME_PASSAGEIRO"];
        $CLASSE = $row["CLASSE"];
        $CPF = $row["CPF_PASSAGEIRO"];
        $CODIGO_VOO = $row["CODIGO_VOO"];
        $DATA_IDA = $row["DATA_IDA"];
        $DATA_CHEGADA = $row["DATA_CHEGADA"];
        $ORIGEM = $row["LOCAL_DE_ORIGEM"];
        $DESTINO = $row["LOCAL_DE_DESTINO"];
        $OPERADORA = $row["OPERADORA"];
        $ASSENTO = $row["ASSENTO"];
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
    <title><?php echo $CODIGO_PASSAGEM ?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index/index.php">
          <img src="../imagens/flyboardNavBar.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
          FlyBoard
        </a>
        <div class="pd-10 d-flex justify-content-center"><span>Informações Da Passagem</span></div>
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
            <div id="comtImgUserNav">
              <img id="userImgNav" src="<?php echo $rowNavBar['USERIMAGEPATH'] ?>" alt="">
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
                        <button type="button" id="btnModal" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button"id="btnModal" class="btn btn-danger" onclick="sair()">Sim, sair</button>
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
      <h2>Codigo Passagem: <?php echo $CODIGO_PASSAGEM?></h2>
      <br>
      <H5>info do voo:</H5>
      <p>codigo voo: <?php echo $CODIGO_VOO ?></p>  
      <p>Destino: <?php echo $DESTINO ?></p>
      <p>Origem: <?php echo $ORIGEM ?></p>
      <p>Data ida: <?php echo $DATA_IDA ?></p>
      <p>Data chegada: <?php echo $DATA_CHEGADA ?></p>
      <p>Operadora: <?php echo $OPERADORA ?></p>
        
   
      <h5>info passageiro:</h5>
        <p>Nome: <?php echo $NOME_PASSAGEIRO ?></p>
        <p>CPF: <?php echo $CPF ?></p>

        <h6>Assento:</h6>
        <p><?php echo $ASSENTO ?></p>

        <h6>Classe:</h6>
        <p><?php echo $CLASSE ?></p>







    </div>
    <div class="col">
     
    </div>
  </div>
</div>
