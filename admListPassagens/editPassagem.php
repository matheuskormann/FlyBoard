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
?>
    <!DOCTYPE html>
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
if (isset($_POST['atualizarDados'])) {
    $editNomePassageiro = $_POST['txtNomePassageiro'];
    $editCPF = $_POST['txtCPF'];
    $editClasse = $_POST['txtClasse'];
    $editAssento = $_POST['txtAssento'];
    $id = $_GET["id"];
    
    // Usando consulta preparada para prevenir SQL Injection
    $sql = "UPDATE PASSAGENS SET NOME_PASSAGEIRO = ?, CPF_PASSAGEIRO = ?, CLASSE = ?, ASSENTO = ? WHERE ID_PASSAGEM = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $editNomePassageiro, $editCPF, $editClasse, $editAssento, $id);
    
    if ($stmt->execute()) {
        echo "<script>
        window.location.href = './listPassagem.php?result=successDataUpdate';
        </script>";
    } else {
        echo "<script>
        const ToastRegex = document.getElementById('ToastRegex');
        const toastBody = ToastRegex.querySelector('.toast-body');
        toastBody.textContent = 'Falha ao atualizar a bagagem, tente novamente.';
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex);
        toastBootstrap.show();
        </script>";
    }
    
    // Fechar a declaração preparada
    $stmt->close();
}
?>
<body>
<div id="conteinerButtom">
    <a id="botaoVoltar" type="button" class="btn btn-light" href="./listPassagem.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
</div>
<div class="container">
<div class="row align-items-start">
<div class="col">
</div>
<div class="col-6   ">
    <h1>Dados:</h1>
    <form method="POST">
        <table class="table  table-borderless" id="conteinerDadados">
            <tr>
              <th class="" scope="row">codigo Passagem:</th>
              <td ><?php echo $CODIGO_PASSAGEM?></td>
            </tr>
            <tr>
              <th class="" scope="row">Codigo Voo:</th>
              <td ><?php echo $CODIGO_VOO ?></td>
            </tr>
            <tr>
                <th class="" scope="row">Data Ida:</th>
                <td ><?php echo $DATA_IDA ?></td>
            </tr>
            <tr>
                <th class="" scope="row">Data Chegada:</th>
                <td ><?php echo $DATA_CHEGADA ?></td>
            </tr>
            <tr>
                <th class="" scope="row">Origem:</th>
                <td ><?php echo $ORIGEM ?></td>
            </tr>
            <tr>
                <th class="" scope="row">Destino:</th>
                <td ><?php echo $DESTINO ?></td>
            </tr>
        </table>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nome Passageiro:</label>
            <input type="txt" name="txtNomePassageiro" class="form-control" id="exampleFormControlInput2" value="<?php echo $NOME_PASSAGEIRO ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">CPF Passageiro:</label>
            <input type="txt" name="txtCPF" class="form-control" id="exampleFormControlInput2" value="<?php echo $CPF ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Assento:</label>
            <input type="txt" name="txtAssento" class="form-control" id="exampleFormControlInput2" value="<?php echo $ASSENTO ?>">
        </div>
        <div class="mb-3">
            <label for="txtClasse" class="form-label">Classe:</label>
            <select class="form-select" name="txtClasse" id="txtClasse">
                <option value="<?php echo $CLASSE ?>"><?php echo $CLASSE ?></option>
                <option value="Econômica">Econômica</option>
                <option value="Econômica Plus">Econômica Plus</option>
                <option value="Executiva">Executiva</option>
                <option value="Primeira Classe">Primeira Classe</option>
            </select>
            </div> 
            <button name="atualizarDados" class="btn btn-primary mb-3" type="submit">Salvar</button>
        </form> 
    </div>
    <div class="col">
    </div>
  </div>
</div>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>