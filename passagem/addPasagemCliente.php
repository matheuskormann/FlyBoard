<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit; 
} 
$id = $_SESSION["id"];
$iduser = $_SESSION["id"];
$sqlNavBar = "SELECT NAME ,EMAIL , ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $iduser";
$resultNavBar = $conn->query($sqlNavBar);
$rowNavBar = $resultNavBar->fetch_assoc();

// Check if the connection is established
if ($conn) {
    $sql = "SELECT NAME , EMAIL, ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $id";
    $result = $conn->query($sql);
        // Add missing import statement

        $row = $result->fetch_assoc();

        // Inicialização das variáveis
        $selectedFlightDetails = null;
        $idVooSelected = null; // Variável para armazenar o ID do voo selecionado

        if(isset($_POST['searchInput'])) {
            $searchInput = $_POST['searchInput'];
            $sql_search = "SELECT * FROM VOOS WHERE CODIGO_VOO LIKE '%$searchInput%' OR LOCAL_DE_ORIGEM LIKE '%$searchInput%' OR LOCAL_DE_DESTINO LIKE '%$searchInput%'";
            $result_search = $conn->query($sql_search);
        }
        else{
            $sql_search = "SELECT * FROM VOOS";
            $result_search = $conn->query($sql_search);
        }

        if(isset($_POST['selectedFlightId'])) {
            $selectedFlightId = $_POST['selectedFlightId'];
            $sql_selected_flight = "SELECT * FROM VOOS WHERE ID_VOO = $selectedFlightId";
            $result_selected_flight = $conn->query($sql_selected_flight);
            if($result_selected_flight->num_rows > 0) {
                $selectedFlightDetails = $result_selected_flight->fetch_assoc();
                $idVooSelected = $selectedFlightId; // Salvando o ID do voo selecionado
            }
        }

        // Processo de adição de passagem
        if (isset($_POST['AdicionarPasagem'])) {
            $codigoPassagem = $_POST['txtCodigoPassagem'];
            $nomePassageiro = $_POST['txtNomePassageiro'];
            $cpfPassageiro = $_POST['txtCpfPassageiro'];
            $Classe = $_POST['txtClasse'];
            $idUser = $_SESSION['id'];
            $Assento = $_POST['txtAssento'];
            // $idVoo = $_POST['selectedFlightId']; // Removido, pois vamos usar $idVooSelected
            $idVoo = $idVooSelected; // Usando a variável $idVooSelected

            $sql_insert_passagem = "INSERT INTO PASSAGENS (CODIGO_PASSAGEM , NOME_PASSAGEIRO, CPF_PASSAGEIRO, CLASSE, ASSENTO, FK_USERS_ID_USER, FK_VOOS_ID_VOO ) VALUES('$codigoPassagem', '$nomePassageiro', '$cpfPassageiro', '$Classe','$Assento', '$idUser', '$idVoo')";
            $result_insert_passagem = $conn->query($sql_insert_passagem);

            if ($result_insert_passagem === TRUE) {
                header("Location: ../homes/homeCliente.php?result=successaddPassagem");
                exit;
            } else {
                header("Location: ../homes/homeCliente.php?result=erro");
                exit;
            }
        }
    } else {
        // Handle connection error
        exit;
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

        <div class="container">
            <h1>NOVA PASSAGEM</h1>

            <?php if(isset($selectedFlightDetails)){ ?>
            <div class="row">
                <div class="col-lg-6">
                    <form method="POST" enctype="multipart/form-data">
                    <div class="mt-3">
                        <h4>Voo Selecionado:</h4>
                        <p><strong>Código do Voo:</strong> <?php echo $selectedFlightDetails['CODIGO_VOO']; ?></p>
                        <p><strong>Origem:</strong> <?php echo $selectedFlightDetails['LOCAL_DE_ORIGEM']; ?></p>
                        <p><strong>Destino:</strong> <?php echo $selectedFlightDetails['LOCAL_DE_DESTINO']; ?></p>
                        <p><strong>Data de Partida:</strong> <?php echo $selectedFlightDetails['DATA_IDA']; ?></p>
                        <p><strong>Operadora:</strong> <?php echo $selectedFlightDetails['OPERADORA']; ?></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    
                        <div class="mb-3">
                            <label for="txtCodigoPassagem" class="form-label">Código da Passagem</label>
                            <input type="text" name="txtCodigoPassagem" class="form-control" id="txtCodigoPassagem">
                        </div> 
                        <div class="mb-3">
                            <label for="txtNomePassageiro" class="form-label">Nome Completo do Passageiro:</label>
                            <input type="text" name="txtNomePassageiro" class="form-control" id="txtNomePassageiro">
                        </div>      
                        <div class="mb-3">
                            <label for="txtCpfPassageiro" class="form-label">CPF Passageiro:</label>
                            <input type="text" name="txtCpfPassageiro" class="form-control" id="txtCpfPassageiro" placeholder="xxx.xxx.xxx-xx" maxlength="14" oninput="formatarCpf(this)">
                        </div>
                        <div class="mb-3">
                            <label for="txtCpfPassageiro" class="form-label">Assento:</label>
                            <input type="text" name="txtAssento" class="form-control" id="txtAssento" placeholder="" maxlength="5">
                        </div>
                        <div class="mb-3">
                            <label for="txtClasse" class="form-label">Classe:</label>
                            <select class="form-select" name="txtClasse" id="txtClasse">
                                <option value="Econômica">Econômica</option>
                                <option value="Econômica Plus">Econômica Plus</option>
                                <option value="Executiva">Executiva</option>
                                <option value="Primeira Classe">Primeira Classe</option>
                            </select>
                        </div> 
                        <input type="hidden" name="selectedFlightId" value="<?php echo $idVooSelected; ?>"> <!-- Campo oculto para manter o ID do voo selecionado -->
                        <button type="submit" name="AdicionarPasagem" class="btn btn-success">Adicionar Passagem</button>
                    </form>
                </div>
                 
                    <?php } 
                    else{
                        ?>
                        <div class="col-lg">
                        <h2>Buscar Voo</h2>
                        <form method="POST">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="text" name="searchInput" class="form-control mb-3" placeholder="Digite o código do voo">
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
                                    <th>Código do Voo</th>
                                    <th>Origem</th>
                                    <th>Destino</th>
                                    <th>Data de Partida</th>
                                    <th>Selecionar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($result_search) && $result_search->num_rows > 0) {
                                    while ($row = $result_search->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['CODIGO_VOO'] . "</td>";
                                        echo "<td>" . $row['LOCAL_DE_ORIGEM'] . "</td>";
                                        echo "<td>" . $row['LOCAL_DE_DESTINO'] . "</td>";
                                        echo "<td>" . $row['DATA_IDA'] . "</td>";
                                        echo "<td><form method='POST'><input type='hidden' name='selectedFlightId' value='" . $row['ID_VOO'] . "'><button type='submit' class='btn btn-success'>Selecionar</button></form></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    ?>
                                <div class="alert alert-warning" role="alert">
                                    Nenhum voo encontrado.
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

      <script> 
            function formatarCpf(campo) {
                var cpf = campo.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                var cpfFormatado = '';

                if (cpf.length <= 3) {
                    cpfFormatado = cpf;
                } else if (cpf.length <= 6) {
                cpfFormatado = cpf.substring(0, 3) + '.' + cpf.substring(3);
            } else if (cpf.length <= 9) {
                cpfFormatado = cpf.substring(0, 3) + '.' + cpf.substring(3, 6) + '.' + cpf.substring(6);
            } else {
                cpfFormatado = cpf.substring(0, 3) + '.' + cpf.substring(3, 6) + '.' + cpf.substring(6, 9) + '-' + cpf.substring(9);
            }

            campo.value = cpfFormatado;
        }
    </script>
</body>
</html>
