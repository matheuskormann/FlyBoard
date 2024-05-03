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
if(isset($_POST['searchInput'])) {
    $searchInput = $_POST['searchInput'];
    $sql_search = "SELECT p.*, v.* FROM PASSAGENS p 
                   INNER JOIN VOOS v ON p.FK_VOOS_ID_VOO = v.ID_VOO 
                   WHERE (p.CODIGO_PASSAGEM LIKE '%$searchInput%' 
                   OR p.NOME_PASSAGEIRO LIKE '%$searchInput%' 
                   OR p.CPF_PASSAGEIRO LIKE '%$searchInput%' 
                   OR v.CODIGO_VOO LIKE '%$searchInput%' 
                   OR v.LOCAL_DE_ORIGEM LIKE '%$searchInput%' 
                   OR v.LOCAL_DE_DESTINO LIKE '%$searchInput%')";   
    $result_search = $conn->query($sql_search);
}
else {
    $sql_search = "SELECT p.*, v.* 
                   FROM PASSAGENS p 
                   INNER JOIN VOOS v ON p.FK_VOOS_ID_VOO = v.ID_VOO ";
    $result_search = $conn->query($sql_search);
}
if(isset($_POST['selectedPassagemId'])) {
    $selectedFlightId = $_POST['selectedPassagemId'];
    $sql_selected_flight = "SELECT v.*, p.* FROM VOOS v 
                            LEFT JOIN PASSAGENS p ON v.ID_VOO = p.FK_VOOS_ID_VOO 
                            WHERE v.ID_VOO = $selectedFlightId";
    $result_selected_flight = $conn->query($sql_selected_flight);
    if($result_selected_flight->num_rows > 0) {
        $selectedFlightDetails = $result_selected_flight->fetch_assoc();
        $idPassagemSelected = $selectedFlightId; 
    }
}

 // Processo de adição de passagem
 if (isset($_POST['AdicionarBagagem'])) {
    $codigoBagagem = $_POST['txtCodigoBagebem'];
    $peso = $_POST['txtPeso'];
    $descricao = $_POST['txtDescricao'];
    $tipo = $_POST['txtTipo'];
    $status= $_POST['txtStatus'];
    $idPassagem = $idPassagemSelected; // Usando a variável $idVooSelected

    $sql_insert_bagagem = "INSERT INTO BAGAGENS (CODIGO_BAGAGEM , PESO, TIPO, DESCRICAO, STATUS_BAGAGEM, FK_PASSAGENS_ID_PASSAGEM ) VALUES('$codigoBagagem', '$peso', '$tipo', '$descricao', '$status', $idPassagem)";
    $result_insert_bagagem = $conn->query($sql_insert_bagagem);

    if ($result_insert_bagagem === TRUE) {
        header("Location: ./listBagagens.php?result=successAddBagagem");
        exit;
    } else {
        header("Location: ./listBagagens.php?result=erro");
        exit;
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

    <div class="container">
        <h1>Nova Bagagem</h1>

        <?php if(isset($selectedFlightDetails)){ ?>
        <div class="row">
            <div class="col-lg-6">
                <form method="POST" enctype="multipart/form-data">
                <div class="mt-3">
                    <h4>Pssagem Selecionada: </h4>
                    <p><strong>Código Passagem:</strong> <?php echo $selectedFlightDetails['CODIGO_PASSAGEM']; ?></p>
                    <p><strong>Nome Passageiro: </strong> <?php echo $selectedFlightDetails['NOME_PASSAGEIRO']; ?></p>
                    <p><strong>CPF Passageiro: </strong> <?php echo $selectedFlightDetails['CPF_PASSAGEIRO']; ?></p>
                    <p><strong>Destino: </strong> <?php echo $selectedFlightDetails['LOCAL_DE_DESTINO']; ?></p>
                    <p><strong>Data de saida:</strong> <?php echo $selectedFlightDetails['DATA_IDA']; ?></p>
                </div>
            </div>
            <div class="col-lg-6">
                
                    <div class="mb-3">
                        <label for="txtCodigoBagebem" class="form-label">CODIGO_BAGAGEM:</label>
                        <input type="text" name="txtCodigoBagebem" class="form-control" id="txtCodigoBagebem">
                    </div> 
                    <div class="mb-3">
                        <label for="txtPeso" class="form-label">PESO:</label>
                        <input type="text" name="txtPeso" class="form-control" id="txtPeso">
                    </div>      
                    <div class="mb-3">
                        <label for="txtDescricao" class="form-label">DESCRICAO:</label>
                        <input type="text" name="txtDescricao" class="form-control" id="txtDescricao">
                    </div>
                    <div class="mb-3">
                        <label for="txtTipo" class="form-label">TIPO</label>
                        <select class="form-select" name="txtTipo" id="txtTipo">
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
                        <label for="txtStatus" class="form-label">Status</label>
                        <select class="form-select" name="txtStatus" id="txtStatus">
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
                </div>
                    <input type="hidden" name="selectedPassagemId" value="<?php echo $idPassagemSelected; ?>"> <!-- Campo oculto para manter o ID do voo selecionado -->
                    <button type="submit" name="AdicionarBagagem" class="btn btn-success">Adicionar Bagagem</button>
                </form>
            </div>
             
                <?php } 
                else{
                    ?>
                    <div class="col-lg">
                    <h2>Buscar Passagem</h2>
                    <form method="POST">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="searchInput" class="form-control mb-3" placeholder="Busacar">
                            </div>
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Código da Passagem</th>
                                <th>Nome Passageiro</th>
                                <th>CPF Passageiro</th>
                                <th>local de saida</th>
                                <th>data de saida</th>
                                <th>Selecionar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($result_search) && $result_search->num_rows > 0) {
                                while ($row = $result_search->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['CODIGO_PASSAGEM'] . "</td>";
                                    echo "<td>" . $row['NOME_PASSAGEIRO'] . "</td>";
                                    echo "<td>" . $row['CPF_PASSAGEIRO'] . "</td>";
                                    echo "<td>" . $row['LOCAL_DE_ORIGEM'] . "</td>";
                                    echo "<td>" . $row['DATA_IDA'] . "</td>";
                                    echo "<td><form method='POST'><input type='hidden' name='selectedPassagemId' value='" . $row['ID_PASSAGEM'] . "'><button type='submit' class='btn btn-success'>Selecionar</button></form></td>";
                                    echo "</tr>";
                                }
                            } else {
                                ?>
                                <div class="alert alert-warning" role="alert">
                                   Nenhuma passagem encontrada para este usuário. 
                                 </div>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                }?>
            </div>
        </div>
    </div>
