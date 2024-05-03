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
    <title>Document</title>
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
$sql = "SELECT B.ID_BAGAGEM, B.CODIGO_BAGAGEM, B.PESO, B.TIPO, B.DESCRICAO, B.STATUS_BAGAGEM, P.NOME_PASSAGEIRO, V.CODIGO_VOO
        FROM BAGAGENS B
        INNER JOIN PASSAGENS P ON B.FK_PASSAGENS_ID_PASSAGEM = P.ID_PASSAGEM
        INNER JOIN VOOS V ON P.FK_VOOS_ID_VOO = V.ID_VOO
        WHERE B.ID_BAGAGEM = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $CODIGO_BAGAGEM = $row["CODIGO_BAGAGEM"]; //nao e posivel mudar o codigo da bagagem
        $PESO = $row["PESO"];
        $TIPO = $row["TIPO"];
        $DESCRICAO = $row["DESCRICAO"];
        $STATUS_BAGAGEM = $row["STATUS_BAGAGEM"];
        $NOME_PASSAGEIRO = $row["NOME_PASSAGEIRO"]; //nao e posivel mudar o nome do passageiro
        $CODIGO_VOO = $row["CODIGO_VOO"]; //Nao e posivel mudar o codigo do voo
    }
}


if (isset($_POST['atualizarDados'])) {
    $editPeso = $_POST['txtPeso'];
    $editTipo = $_POST['txtTipo'];
    $editDescricao = $_POST['txtDescricao'];
    $editStatusBagagem = $_POST['txtStatusBagagem'];
    $id = $_GET["id"];
    
    // Usando consulta preparada para prevenir SQL Injection
    $sql2 = "UPDATE BAGAGENS SET PESO = ?, TIPO = ?, DESCRICAO = ?, STATUS_BAGAGEM = ? WHERE ID_BAGAGEM = ?";
    $stmt = $conn->prepare($sql2);
    $stmt->bind_param('ssssi', $editPeso, $editTipo, $editDescricao, $editStatusBagagem, $id);
    
    if ($stmt->execute()) {
        echo "<script>
        window.location.href = './listBagagens.php?result=successDataUpdate';
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
        <a id="botaoVoltar" type="button" class="btn btn-light" href="./listBagagens.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
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
                  <th class="" scope="row">codigo Bagagem:</th>
                  <td ><?php echo $CODIGO_BAGAGEM ?></td>
                </tr>
                <tr>
                  <th class="" scope="row">Nome Passageiro:</th>
                  <td ><?php echo $NOME_PASSAGEIRO ?></td>
                </tr>
                <tr>
                  <th class="" scope="row">Codigo voo:</th>
                  <td ><?php echo $CODIGO_VOO ?></td>
                </tr>
            </table>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Peso:</label>
                <input type="txt" name="txtPeso" class="form-control" id="exampleFormControlInput2" value="<?php echo $PESO ?>">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Descriçao:</label>
                <input type="txt" name="txtData_Ida" class="form-control" id="exampleFormControlInput1" value="<?php echo $DESCRICAO ?>">
            </div>
            <div class="mb-3">
                <label for="txtTipo" class="form-label">TIPO</label>
                <select class="form-select" name="txtTipo" id="txtTipo" value="<?php echo $TIPO ?>">
                    <option selected><?php echo $TIPO ?></option>
                    <option value="Bagagem de mão">Bagagem de mão </option>
                    <option value="Bagagem despachad">Bagagem despachada</option>
                    <option value="Bagagem despachada fragil">Bagagem despachada fragil</option>
                    <option value="Bagagem especial">Bagagem especial</option>
                    <option value="Bagagem de valor">Bagagem de valor</option>
                    <option value="Carga">Carga</option>
                    <option value="Carga Viva">Carga Viva</option>
                </select>
            </div> 
            <div class="mb-3">
                <label for="txtStatusBagagem" class="form-label">Status</label>
                <select class="form-select" name="txtStatusBagagem" id="txtStatusBagagem" value="<?php echo $STATUS_BAGAGEM ?>">
                    <option selected><?php echo $STATUS_BAGAGEM ?></option>
                    <option value="cadastrada">cadastrada</option>
                    <option value="Despachada">Despachada</option>
                    <option value="Passando pela segurança">Passando pela segurança</option>
                    <option value="Aguardando embarque">Aguardando embarque</option>
                    <option value="Embarcada">Embarcada</option>
                    <option value="Em voo">Em voo</option>
                    <option value="Aguardando para desembarque">Aguardando para desembarque</option>
                    <option value="Aesembarcado / a caminho da esteira">Aesembarcado / A caminho da esteira</option>
                    <option value="Entregue">Entregue</option>
                    <option value="Aguardando retirada">Aguardando retirada</option>
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
</body>
</html>

