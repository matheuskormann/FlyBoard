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
