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
$id = $_GET["id"];
$sql = "SELECT ID_VOO, CODIGO_VOO,LOCAL_DE_ORIGEM, LOCAL_DE_DESTINO, DATA_IDA, DATA_CHEGADA, PORTAO_EMBARQUE, AERONAVE, CODIGO_AERONAVE, OPERADORA, VOOIMAGEMPATH FROM VOOS WHERE ID_VOO = $id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
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
$iduser = $_SESSION["id"];
$sqlNavBar = "SELECT NAME ,EMAIL , ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $iduser";
$resultNavBar = $conn->query($sqlNavBar);
$rowNavBar = $resultNavBar->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./voosLstStyle.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title><?php echo $CODIGO_VOO ?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index/index.php">
          <img src="../imagens/flyboardNavBar.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
          FlyBoard
        </a>
        <div class="pd-10 d-flex justify-content-center"><span>Informações do Voo</span></div>
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
        <a id="botaoVoltar" type="button" class="btn btn-light" href="./listVoos.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Imagem:</h1>
                <div class="">
                        <div id="comtImgUser">
                            <img height="175px" id="userImg" src="<?php echo $VOOIMAGEMPATH ?>" alt="">
                        </div>
                </div>
            </div>
            <div class="col">
                <h1>Dados do Voo:
                </h1>
                <div class="container">
                    <table class="table  table-borderless" id="conteinerDadados">
                       <tr>
                        <th class="" scope="row">Código:</th>
                        <td ><?php echo $CODIGO_VOO ?></td>
                       </tr>
                       <tr>
                         <th class="" scope="row">Portão de Embarque:</th>
                         <td ><?php echo $PORTAO_EMBARQUE ?></td>
                        </tr>
                        <tr>
                         <th class="" scope="row">Avião: </th>
                         <td ><?php echo $AERONAVE ?></td>
                        </tr>
                        <tr>
                         <th class="" scope="row">Código Avião: </th>
                         <td ><?php echo $CODIGO_AERONAVE ?></td>
                        </tr>
                        <tr>
                         <th class="" scope="row">Compania Aérea:</th>
                         <td><?php echo $OPERADORA ?></td>
                        </tr>
                    </table>
                    
                    <table class="table table-borderless text-center">
                       <tr>
                       <th scope="row"><img src="../imagens/partida-de-aviao.png" alt="viagem-de-aviao"style="width: 25px; height: 25px;">  Saída</th>
                      <th></th>
                       <th scope="row"><img src="../imagens/chegada-do-aviao.png" alt="viagem-de-aviao"style="width: 25px; height: 25px;">  Chegada</th>
                       
                       </tr>
                       <tr>
                       <td><?php echo $ORIGEM ?></td>
                       <td><img src="../imagens/viagem-de-aviao.png" alt="viagem-de-aviao"style="width: 25px; height: 25px;"></td>
                       <td><?php echo $DESTINO ?></td>
                       </tr>
                       <tr>
                       <td><?php echo $DATA_IDA ?></td>
                      <td></td>
                       <td><?php echo $DATA_CHEGADA ?></td>
                       </tr>
                    </table>

                    
                </div>
            </div>
        </div>
    </div>
    
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



