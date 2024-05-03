<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit; 
}   

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
    <title><?php echo $CODIGO_BAGAGEM ?></title>
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
      <h2>Codigo Bagagem: <?php echo $CODIGO_BAGAGEM ?></h2>
      <br>
      <H5>info do voo:</H5>
      <p>codigo voo: <?php echo $CODIGO_VOO ?></p>
      <p>Destino: <?php echo $DESTINO ?></p>
      <p>Origem: <?php echo $ORIGEM ?></p>
   
      <h5>info passageiro:</h5>
        <p>Nome: <?php echo $NOME_PASSAGEIRO ?></p>
        <p>CPF: <?php echo $CPF_PASSAGEIRO ?></p>
       
        <h5>info bagagem:</h5>
        <p>Peso: <?php echo $PESO ?></p>
        <p>Tipo: <?php echo $TIPO ?></p>
        <p>Descricao: <?php echo $DESCRICAO ?></p>
        <div class="alert alert-secondary" role="alert">Status da Bagagem: <?php echo $STATUS_BAGAGEM ?></div>







    </div>
    <div class="col">
     
    </div>
  </div>
</div>
