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
$iduser = $_SESSION["id"];
$sqlNavBar = "SELECT NAME ,EMAIL , ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $iduser";
$resultNavBar = $conn->query($sqlNavBar);
$rowNavBar = $resultNavBar->fetch_assoc();

if(isset($_POST['searchInputUser'])) {
    $searchInputUser = $_POST['searchInputUser'];
    $sql_searchUser = "SELECT * FROM USERS WHERE NAME LIKE '%$searchInputUser%' OR EMAIL LIKE '%$searchInputUser%'";   
    $result_searchUser = $conn->query($sql_searchUser);
}
else {
    $sql_searchUser = "SELECT * FROM USERS";
    $result_searchUser = $conn->query($sql_searchUser);
}

if(isset($_POST['searchInputVoos'])) {
    $searchInputVoos = $_POST['searchInputVoos'];
    $sql_searchVoos = "SELECT * FROM VOOS WHERE CODIGO_VOO LIKE '%$searchInputVoos%' OR LOCAL_DE_ORIGEM LIKE '%$searchInputVoos%' OR LOCAL_DE_DESTINO LIKE '%$searchInputVoos%'";   
    $result_searchVoos = $conn->query($sql_searchVoos);
}
else {
    $sql_searchVoos = "SELECT * FROM VOOS";
    $result_searchVoos = $conn->query($sql_searchVoos);
}



if(isset($_POST['selectedUserId'])) {
    $selectedUserId = $_POST['selectedUserId'];
    $idUserSelected = $selectedUserId;
    ?>
    <script>
        console.log(<?php echo $selectedUserId; ?>);
    </script>
    <?php
    $sql_selected_User = "SELECT * FROM USERS WHERE ID_USER = $selectedUserId";
    $result_selected_User = $conn->query($sql_selected_User);
    if($result_selected_User->num_rows > 0) {
        $selectedUserDetails = $result_selected_User->fetch_assoc();
        $idUserSelected = $selectedUserId; 
    }
}

if(isset($_POST['selectedVooId'])) {
    $selectedVooId = $_POST['selectedVooId'];
    $selectedUserId = $_POST['selectedUserId'];
    $sql_selected_Voo = "SELECT * FROM VOOS WHERE ID_VOO = $selectedVooId";
    $result_selected_Voo = $conn->query($sql_selected_Voo);
    if($result_selected_Voo->num_rows > 0) {
        $selectedVooDetails = $result_selected_Voo->fetch_assoc();
        $idVooSelected = $selectedVooId; 
    }
    $sql_selected_User = "SELECT * FROM USERS WHERE ID_USER = $selectedUserId";
    $result_selected_User = $conn->query($sql_selected_User);
    if($result_selected_User->num_rows > 0) {
        $selectedUserDetails = $result_selected_User->fetch_assoc();
        $idUserSelected = $selectedUserId; 
    }
}

 // Processo de adição de passagem
 if (isset($_POST['AdicionarPassagem'])) {
    
    $codigoPassagem = $_POST['txtCodigoPassagem'];
    $nomePassageiro = $_POST['txtNomePassageiro'];
    $cpfPassageiro = $_POST['txtCpfPassageiro'];
    $classe = $_POST['txtClasse'];
    $idUserSelected = $_POST['selectedUserId'];
    $idVooSelected = $_POST['selectedVootId'];
    $Assento = $_POST['txtAssento'];

    $sql_insert_Passagem = "INSERT INTO PASSAGENS (CODIGO_PASSAGEM, NOME_PASSAGEIRO, CPF_PASSAGEIRO, CLASSE, FK_USERS_ID_USER, FK_VOOS_ID_VOO, ASSENTO) VALUES ('$codigoPassagem', '$nomePassageiro', '$cpfPassageiro', '$classe', $idUserSelected, $idVooSelected, '$Assento')";
    $result_insert_Passagem = $conn->query($sql_insert_Passagem);

    if ($result_insert_Passagem === TRUE) {
        header("Location: ./listPassagem.php?result=successAddPassagem");
        exit;
    } else {
        header("Location: ./listPassagem.php?result=erro");
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
    <link rel="shortcut icon" href="../imagens/flyboardLOGOremovido.ico" type="image/x-icon">
    <title>ADD Passagem</title>
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
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index/index.php">
          <img src="../imagens/flyboardNavBar.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
          FlyBoard
        </a>
        <div class="pd-10 d-flex justify-content-center"><span>Localizar Bagagem</span></div>
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
<?php
if(isset($selectedVooDetails))
{
    ?>
    <script>
        console.log(<?php echo $selectedUserId; ?>);
        console.log(<?php echo $selectedVooId; ?>);
    </script>
    <div class="row">
            <div class="col-lg-6">
                <form method="POST" enctype="multipart/form-data">
                <?php
                    ?>
                    <div class="mt-3">
                        <h4>User Selecionado: </h4>
                        <p><strong>Nome:</strong> <?php echo $selectedUserDetails['NAME']; ?></p>
                        <p><strong>Email:</strong> <?php echo $selectedUserDetails['EMAIL']; ?></p>
                    </div>
                <?php
                
                ?>
                <div class="mt-3">
                    <h4>Voo Selecionado: </h4>
                    <p><strong>Codigo Voo:</strong> <?php echo $selectedVooDetails['CODIGO_VOO']; ?></p>
                    <p><strong>Origem:</strong> <?php echo $selectedVooDetails['LOCAL_DE_ORIGEM']; ?></p>
                    <p><strong>Destino:</strong> <?php echo $selectedVooDetails['LOCAL_DE_DESTINO']; ?></p>
                    <p><strong>Data Ida:</strong> <?php echo $selectedVooDetails['DATA_IDA']; ?></p>
                    <p><strong>Operadora:</strong> <?php echo $selectedVooDetails['OPERADORA']; ?></p>
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
                            <label for="txtAssento" class="form-label">Assento:</label>
                            <input type="text" name="txtAssento" class="form-control" id="txtAssento" placeholder="" maxlength="4">
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
                        <input type="hidden" name="selectedUserId" value="<?php echo $idUserSelected; ?>">  <!-- Campo oculto para manter o ID do usuário selecionado -->
                        <input type="hidden" name="selectedVootId" value="<?php echo $idVooSelected; ?>"> <!-- Campo oculto para manter o ID do voo selecionado -->
                        <button type="submit" name="AdicionarPassagem" class="btn btn-success">Adicionar Passagem</button>
                </form>
            </div>
             
<?php
}
elseif(isset($selectedUserDetails)) {
    ?>
    <div class="col-lg">
        <h2>Selecionar Voo:</h2>
        <!-- Tabela de Voo -->
        <form method="POST">
            <div class="row">
                <div class="col-lg-6">
                    <input type="text" name="searchInputVoo" class="form-control mb-3" placeholder="Busacar">
                </div>
                <div class="col-lg-6">
                     <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <th scope="col">CODIGO VOO</th>
                    <th scope="col">ORIGEM</th>
                    <th scope="col">DESTINO</th>
                    <th scope="col">DATA_IDA</th>
                    <th scope="col">OPERADORA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_searchVoos ->num_rows > 0) {
                        while ($row_voos = $result_searchVoos->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row_voos['CODIGO_VOO'] . "</td>";
                            echo "<td>" . $row_voos['LOCAL_DE_ORIGEM'] . "</td>";
                            echo "<td>" . $row_voos['LOCAL_DE_DESTINO'] . "</td>";
                            echo "<td>" . $row_voos['DATA_IDA'] . "</td>";
                            echo "<td>" . $row_voos['OPERADORA'] . "</td>";
                            echo "<td><form method='POST' id='form_select_voo_" . $row_voos['ID_VOO'] . "'><input type='hidden' name='selectedUserId' value='" . $idUserSelected . "'><input type='hidden' name='selectedVooId' value='" . $row_voos['ID_VOO'] . "'><button type='submit' class='btn btn-success'>Selecionar</button></form></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Nenhum Voo encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
else {
    ?>
     <div class="col-lg">
        <h2>Selecionar Usuário:</h2>
        <!-- Tabela de usuários -->
        <form method="POST">
            <div class="row">
                <div class="col-lg-6">
                    <input type="text" name="searchInputUser" class="form-control mb-3" placeholder="Busacar">
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
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Selecionar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_searchUser->num_rows > 0) {
                        while ($row_usuario = $result_searchUser->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row_usuario['ID_USER'] . "</td>";
                            echo "<td>" . $row_usuario['NAME'] . "</td>";
                            echo "<td>" . $row_usuario['EMAIL'] . "</td>";
                            echo "<td><form method='POST'><input type='hidden' name='selectedUserId' value='" .$row_usuario['ID_USER']. "'><button type='submit' class='btn btn-success'>Selecionar</button></form></td>";
                            echo "</tr>"; // Add this line
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Nenhum usuário encontrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <?php
}
?>
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