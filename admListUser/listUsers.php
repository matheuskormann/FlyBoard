<?php
    include('../connections/connection.php');

    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: ../login/login.php");
        exit; 
    }
    else if ($_SESSION["role"] == "admin") {
        echo "<script>
                alert('Você não tem permissão!');
                window.location.href = '../index/index.html';
              </script>";
        exit; 
    }
    $valor = 0;

    function atualizarfiltro($valor, $conn){
        switch ($valor) {
            case 0:
                $sql = "SELECT ID_USER, NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, ROLE FROM USERS";
                $result = $conn->query($sql);
                return $result;
                break;
            case 1:
                $sql1 = "SELECT ID_USER, NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, ROLE FROM USERS WHERE ROLE = 'cliente' ";
                $result1 = $conn->query($sql1);
                return $result1;
                break;
            case 2:
                $sql2 = "SELECT ID_USER, NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, ROLE FROM USERS WHERE ROLE = 'funcionario' ";
                $result2 = $conn->query($sql2);
                return $result2;
                break;
            case 3:
                $sql3 = "SELECT ID_USER, NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, ROLE FROM USERS WHERE ROLE = 'admin' ";
                $result3 = $conn->query($sql3);
                return $result3;
                break;
        }
    }

    // Verifica se o parâmetro 'filtro' foi passado via GET
    if(isset($_GET['filtro'])){
        $valor = $_GET['filtro'];
        $result = atualizarfiltro($valor, $conn);
    } else {
        // Se nenhum filtro foi passado, exibe todos os usuários
        $result = atualizarfiltro($valor, $conn);
    }

    // Busca por nome ou CPF
    if(isset($_POST['search'])){
        $search = $_POST['search'];
        $sql_search = "SELECT ID_USER, NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, ROLE FROM USERS WHERE NAME LIKE '%$search%' OR CPF LIKE '%$search%'";
        $result = $conn->query($sql_search);
    }
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users list</title>
    <link rel="stylesheet" href="userLstStyle.css">
    <link rel="shortcut icon" href="../imagens/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
    
    <?php
        // Número de usuários
        $sql_num_users = "SELECT COUNT(*) AS total FROM users";
        $result_num_users = $conn->query($sql_num_users);
        $row_num_users = $result_num_users->fetch_assoc();
        $total_users = $row_num_users['total'];
    ?>
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
          <a class="nav-link active" aria-current="page">Lista De Usuários</a>
        </li>
        <li class="nav-item">
              <a class="nav-link" href="./addUser.php" role="button" aria-expanded="false">
                Adicionar Usuário
              </a>
        </li>
      </ul>
      <li class="nav-item dropdown  d-flex">
              <a class="nav-link"  aria-expanded="false">Número de Usuários: <?php echo $total_users; ?></a>
            </li>
      </ul>
    </div>
  </div>
</nav>
    <div id="conteinerButtom">
        <a id="botaoVoltar" type="button" class="btn btn-light" href="../homes/homeAdmin.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
    </div>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mb-3">
        <div class="input-group container">
            <input type="text" class="form-control" placeholder="Buscar por nome ou CPF" name="search">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </div>
    </form>
    <div class="btn-group" id="btnFiltro" role="group" aria-label="Basic outlined example">
        <button type="button" onclick="atualizarFiltro(0)" class="btn btn-outline-primary">Todos</button>
        <button type="button" onclick="atualizarFiltro(1)" class="btn btn-outline-primary">Cliente</button>
        <button type="button" onclick="atualizarFiltro(2)" class="btn btn-outline-primary">Funcionario</button>
        <button type="button" onclick="atualizarFiltro(3)" class="btn btn-outline-primary">Admin</button>
        
    </div>
    <div class="container">
        <table id="tabela-usuarios" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Login</th>
                    <th scope="col">Data Nascimento</th>
                    <th scope="col">Cargo</th>
                    <th colspan="2">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                ?>
                            <tr>
                                <td><a href="./userUser.php?id=<?php echo $row['ID_USER'] ?>"><img src="../imagens/idUser.png" alt="user" style="width: 15px; height: 15px;">: <?php echo $row["ID_USER"] ?></a></td>
                                <td><?php echo $row["NAME"] ?></td>
                                <td><?php echo $row["CPF"] ?></td>
                                <td><?php echo $row["EMAIL"] ?></td>
                                <td><?php echo $row["DATA_DE_NASCIMENTO"] ?></td>
                                <td><?php echo $row["ROLE"] ?></td>
                                <td><a href="./editUser.php?id=<?php echo $row['ID_USER'] ?>"><img src="../imagens/editar.png" alt="edit" style="width: 15px; height: 15px;"></a></td>
                                <td data-user-id="<?= $row['ID_USER'] ?>" onclick="showModal(this)"><a href="#"><img src="../imagens/lixo.png" alt="delet" style="width: 15px; height: 15px;"></a></td>
                            </tr>
                <?php
                        }
                    }
                ?>  
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="labelHeader" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h5>Deseja <b>Excluir</b> o Usuário?</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnExcluir" class="btn btn-danger" onclick="excluir(this)">Sim, excluir</button>
                    </div>
                </div>
            </div>
        </div>
        
    <script>
            function showModal(element) {
                const userId = element.dataset.userId;
                $('#modal').modal('show');
                $('#modal button.btn-danger').data('user-id', userId);
            }

        function atualizarFiltro(valor) {
            location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?filtro=" + valor;
        }

        function excluir(element) {
            const userId = $(element).data('user-id');
            location.href = "./deletUser.php?id=" + userId;
        
        }
    </script>
      <script src="../node_modules/jquery/dist/jquery.min.js"></script>
      <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
