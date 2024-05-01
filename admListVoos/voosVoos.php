<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
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
?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./voosLstStyle.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title><?php echo $CODIGO_VOO ?></title>
</head>
<body>
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
                <h1>Dados do voo:
                </h1>
                <div class="container">
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
    </div>
    
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



