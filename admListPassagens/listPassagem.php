<?php
// Inclui a conexão com o banco de dados
include('../connections/connection.php');

// Inicia a sessão
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit; 
}

// Verifica se o usuário não é administrador
else if ($_SESSION["role"] != "admin" && $_SESSION["role"] != "funcionario") {
    echo "<script>
         location.href = '../homes/collectorHomes.php?result=semPermissao';
          </script>";
    exit; 
}
// -- Consulta SQL para obter todas as passagens juntamente com os dados do voo associado
$sql = "SELECT P.*, U.EMAIL, V.*
        FROM PASSAGENS AS P
        JOIN USERS AS U ON P.FK_USERS_ID_USER = U.ID_USER
        JOIN VOOS AS V ON P.FK_VOOS_ID_VOO = V.ID_VOO";
$result = $conn->query($sql);

$sql_num_passagens = "SELECT COUNT(*) AS total FROM PASSAGENS";
$result_num_passagens = $conn->query($sql_num_passagens);
$row_num_passagens = $result_num_passagens->fetch_assoc();
$total_passagens = $row_num_passagens['total'];

if (isset($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);
    // Consulta para buscar informações da bagagem, email do usuário, nome do passageiro e código do voo
    $sql_search_bagagens = "SELECT B.CODIGO_BAGAGEM, U.EMAIL, P.NOME_PASSAGEIRO, V.CODIGO_VOO
                            FROM BAGAGENS B
                            JOIN PASSAGENS P ON B.FK_PASSAGENS_ID_PASSAGEM = P.ID_PASSAGEM
                            JOIN USERS U ON P.FK_USERS_ID_USER = U.ID_USER
                            JOIN VOOS V ON P.FK_VOOS_ID_VOO = V.ID_VOO
                            WHERE P.CODIGO_PASSAGEM LIKE '%$search%'
                            OR P.NOME_PASSAGEIRO LIKE '%$search%'
                            OR P.CPF_PASSAGEIRO LIKE '%$search%'
                            OR V.LOCAL_DE_ORIGEM LIKE '%$search%'
                            OR V.LOCAL_DE_DESTINO LIKE '%$search%'";
    $result_bagagens = $conn->query($sql_search_bagagens);
}



?>
<!DOCTYPE html>
<html lang="pt-br"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="comfig.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <title>List Passagens</title>
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
    <!-- Navbar -->
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
                        <a class="nav-link active">Lista de Passagens</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./addPassagemAdmin.php" role="button">
                            Adicionar Passagem
                        </a>
                    </li>
                </ul>   
                <ul class="navbar-nav">
                    <li class="nav-item dropdown d-flex">
                        <a class="nav-link">Número de Passagem cadastradoa: <?php echo $total_passagens; ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Botão de voltar -->
    <div id="containerButton">
        <a id="botaoVoltar" type="button" class="btn btn-light" href="../homes/collectorHomes.php">
            <img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px">
        </a>
    </div>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mb-3">
        <div class="input-group container">
            <input type="text" class="form-control" placeholder="Buscar por Codigo da Passagem, Nome ou CPF do passageuiro, Origem e Destino" name="search">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </div>
    </form>


        <div class="container">
        <table id="tabela-voos" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Codigo Passagem</th>
                    <th scope="col">Nome Passageiro</th>
                    <th scope="col">CPF Passsageiro</th>
                    <th scope="col">Email Usuario</th>
                    <th scope="col">Destino</th>
                    <th scope="col">Codigo Voo</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Exibe cada voo na tabela
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                ?>
                            <tr>
                                <td><a href="./maisBagagem.php?id= <?php echo $row['ID_PASSAGEM']; ?>"><img src="../imagens/passagem-aerea.png" alt="editar" style="width: 19px; height: 19px; position: relative; bottom: 2px;"> : <?php echo $row["CODIGO_PASSAGEM"]; ?></a></td>
                                <td><?php echo $row["NOME_PASSAGEIRO"]; ?></td>
                                <td><?php echo $row["CPF_PASSAGEIRO"]; ?></td>
                                <td><?php echo $row["EMAIL"]; ?></td>
                                <td><?php echo $row["CLASSE"]; ?></td>
                                <td><?php echo $row["CODIGO_VOO"]; ?></td>
                                <!-- Ações: Editar e Excluir -->
                                <td>
                                    <a href="./editPassagem.php?id=<?php echo $row['ID_PASSAGEM']; ?>">
                                        <img src="../imagens/editar.png" alt="editar" style="width: 15px; height: 15px;">
                                    </a>
                                    <a href="#" data-Bagagem-id="<?php echo $row['ID_PASSAGEM']; ?>" onclick="showModal(<?php echo $row['ID_PASSAGEM']; ?>)">
                                        <img src="../imagens/lixo.png" alt="excluir" style="width: 15px; height: 15px;">
                                    </a>
                                </td>
                            </tr>
                <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de confirmação de exclusão -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h5>Deseja excluir essa Passagem?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnExcluir" onclick="excluirVoo()">Sim, excluir</button>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="semPermissao" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        Você não tem permissão para isso! 
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

    <!-- Scripts -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let BagagemIdParaExcluir;

        // Função para abrir o modal e definir o ID do voo a ser excluído
        function showModal(element) {
            BagagemIdParaExcluir = element
            console.log(BagagemIdParaExcluir); // Move the console.log statement here
            $('#modal').modal('show');
        }

        // Função para excluir o voo
        function excluirVoo() {
            window.location.href = "./deletPassagem.php?id=" + BagagemIdParaExcluir;
        }
        
    </script>

    <?php
    if (isset($_GET["result"])) {
        $result = $_GET["result"];
        if ($result == "successDataUpdate") {
            echo "<script>
            const ToastRegex = document.getElementById('ToastRegex')
            const toastBody = ToastRegex.querySelector('.toast-body');

            toastBody.textContent = 'Dados atualizados com sucesso!';
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
            toastBootstrap.show()
            </script>";
        } 
        else if($result == "successAddPassagem") {
            echo "<script>
            const ToastRegex = document.getElementById('ToastRegex')
            const toastBody = ToastRegex.querySelector('.toast-body');

            toastBody.textContent = 'Passagem adicionad com sucesso!';
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
            toastBootstrap.show()
            </script>";
        } 
        else if($result == "successDelete") {
            echo "<script>
            const ToastRegex = document.getElementById('ToastRegex')
            const toastBody = ToastRegex.querySelector('.toast-body');

            toastBody.textContent = 'Passagem apagado com sucesso!';
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
            toastBootstrap.show()
            </script>";
        } 
        else if($result == "erro") {
            echo "<script>
            const ToastRegex = document.getElementById('ToastRegex')
            const toastBody = ToastRegex.querySelector('.toast-body');

            toastBody.textContent = 'algo deu errado!';
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
            toastBootstrap.show()
            </script>";
        } 
        else if ($result == 'semPermissao') {
            echo "<script>
            const semPermissao = document.getElementById('semPermissao')
    
            const Bootstrap = bootstrap.Toast.getOrCreateInstance(semPermissao)
            Bootstrap.show()
                  </script>";
        }
    }

    ?>
</body>
</html>