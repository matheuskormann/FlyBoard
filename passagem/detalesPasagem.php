<?php
include('../connections/connection.php');
session_start();
if (!isset($_SESSION["id"])) {
  header("Location: ../login/login.php ");
}

$iduser = $_SESSION["id"];
$sqlNavBar = "SELECT NAME ,EMAIL , ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $iduser";
$resultNavBar = $conn->query($sqlNavBar);
$rowNavBar = $resultNavBar->fetch_assoc();

// IDs específicos de usuário e voo
$id_usuario = $_SESSION["id"];
$id_voo = $_GET["idVoo"];// Substitua pelo ID do voo desejado

// Query para selecionar passagens e voos do usuário específico para o voo específico
$sql = "SELECT PASSAGENS.*, VOOS.*
        FROM PASSAGENS
        INNER JOIN VOOS ON PASSAGENS.FK_VOOS_ID_VOO = VOOS.ID_VOO
        WHERE PASSAGENS.FK_USERS_ID_USER = $id_usuario
        AND VOOS.ID_VOO = $id_voo";
$result = $conn->query($sql);
// Query para selecionar informações do voo específico
$sql_voo = "SELECT * FROM VOOS WHERE ID_VOO = $id_voo";
$result_voo = $conn->query($sql_voo);
if ($result_voo->num_rows > 0) {
    while($row = $result_voo->fetch_assoc()) {
        $CODIGO_VOO = $row["CODIGO_VOO"];
        $ORIGEM = $row["LOCAL_DE_ORIGEM"];
        $DESTINO = $row["LOCAL_DE_DESTINO"];
        $DATA_IDA = $row["DATA_IDA"];
        $DATA_CHEGADA = $row["DATA_CHEGADA"];
        $PORTAO_EMBARQUE = $row["PORTAO_EMBARQUE"];
        $AERONAVE = $row["AERONAVE"];
        $OPERADORA = $row["OPERADORA"];
        $CODIGO_AERONAVE = $row["CODIGO_AERONAVE"];
    }
}

?>
<!DOCTYPE html>
    <html lang="pt-br"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
        <title>Voos</title>
    </head>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <body>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="ToastRegex" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
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

<div id="conteinerButtom">
 <a id="botaoVoltar" type="button" class="btn btn-light" href="../homes/homeCliente.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
 </div>
 <div class="container ">
  <div class="row">
    <div class="col">
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
    </div>
    <div class="col">  
        <br>
        <br>
         
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

<?php
if ($result->num_rows > 0) {
    // Exibir os dados
    while($row = $result->fetch_assoc()) {
        ?>
        <div class="container">
            <div class="card mb-3">
              <div class="row g-0">
                <div class="col-lg-4">
                  <img src="<?php echo $row["VOOIMAGEMPATH"] ?>" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                  <div class="card-body coardPassagem" >
                    <h5 class="card-title"><?php echo $row["CODIGO_PASSAGEM"] ?></h5>
                    <p class="card-text"><Samp>Nome Do Passageiro: </Samp><?php echo $row["NOME_PASSAGEIRO"] ?><br><Samp>CPF: </Samp><?php echo $row["CPF_PASSAGEIRO"] ?><br><Samp> Assento: </Samp><?php echo $row["ASSENTO"] ?><br><Samp> Classe: </Samp><?php echo $row["CLASSE"] ?></p>
                  </div>
                </div>
              </div>
            </div>
        </div>
       <?php
    }
} else {
    echo "Nenhuma passagem encontrada para este usuário neste voo.";
}

$conn->close();
?>
</body>