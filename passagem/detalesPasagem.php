<?php
include('../connections/connection.php');
session_start();
if (!isset($_SESSION["id"])) {
  header("Location: ../login/login.php ");
}


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
        $VOOIMAGEMPATH = $row["VOOIMAGEMPATH"];
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

<div id="conteinerButtom">
 <a id="botaoVoltar" type="button" class="btn btn-light" href="../homes/homeCliente.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
 </div>
 <div class="container ">
  <div class="row">
    <div class="col">
        <table class="table  table-borderless" id="conteinerDadados">
           <tr>
            <th class="" scope="row">codigo:</th>
            <td ><?php echo $CODIGO_VOO ?></td>
           </tr>
           <tr>
             <th class="" scope="row">Protao de embarque:</th>
             <td ><?php echo $PORTAO_EMBARQUE ?></td>
            </tr>
            <tr>
             <th class="" scope="row">Aviao: </th>
             <td ><?php echo $AERONAVE ?></td>
            </tr>
            <tr>
             <th class="" scope="row">Codigo Aviao: </th>
             <td ><?php echo $CODIGO_AERONAVE ?></td>
            </tr>
            <tr>
             <th class="" scope="row">Compani aerio:</th>
             <td><?php echo $OPERADORA ?></td>
            </tr>
        </table>
    </div>
    <div class="col">  
        <br>
        <br>
         
        <table class="table table-borderless text-center">
           <tr>
           <th scope="row"><img src="../imagens/partida-de-aviao.png" alt="viagem-de-aviao"style="width: 25px; height: 25px;">  saida</th>
          <th></th>
           <th scope="row"><img src="../imagens/chegada-do-aviao.png" alt="viagem-de-aviao"style="width: 25px; height: 25px;">  chegada</th>
           
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
        echo "ID da Passagem: " . $row["ID_PASSAGEM"]. " - Nome do Passageiro: " . $row["NOME_PASSAGEIRO"]. " - Código do Voo: " . $row["CODIGO_VOO"]. "<br>";
    }
} else {
    echo "Nenhuma passagem encontrada para este usuário neste voo.";
}

$conn->close();
?>
</body>