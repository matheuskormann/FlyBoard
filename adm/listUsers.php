<?php
    include('../connections/connection.php');

    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: ../login/login.html");
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
                $sql = "SELECT id_user, name, cpf, login, data_de_nacimento, password, role FROM users";
                $result = $conn->query($sql);
                return $result;
                break;
            case 1:
                $sql1 = "SELECT id_user, name, cpf, login, data_de_nacimento, password, role FROM users WHERE role = 'cliente' ";
                $result1 = $conn->query($sql1);
                return $result1;
                break;
            case 2:
                $sql2 = "SELECT id_user, name, cpf, login, data_de_nacimento, password, role FROM users WHERE role = 'funcionario   ' ";
                $result2 = $conn->query($sql2);
                return $result2;
                break;
            case 3:
                $sql3 = "SELECT id_user, name, cpf, login, data_de_nacimento, password, role FROM users WHERE role = 'admin' ";
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
        $sql_search = "SELECT id_user, name, cpf, login, data_de_nacimento, password, role FROM users WHERE name LIKE '%$search%' OR cpf LIKE '%$search%'";
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
      flyboard
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page">List Users</a>
        </li>
        <li class="nav-item">
              <a class="nav-link" href="./addUser.php" role="button" aria-expanded="false">
                add user
              </a>
        </li>
      </ul>
      <li class="nav-item dropdown  d-flex">
              <a class="nav-link"  aria-expanded="false">Número de Users: <?php echo $total_users; ?></a>
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
                    <th scope="col">data Nascimento</th>
                    <th scope="col">Senha</th>
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
                                <td><a href="./userUser.php?id=<?php echo $row['id_user'] ?>"><img src="../imagens/idUser.png" alt="user" style="width: 15px; height: 15px;">: <?php echo $row["id_user"] ?></a></td>
                                <td><?php echo $row["name"] ?></td>
                                <td><?php echo $row["cpf"] ?></td>
                                <td><?php echo $row["login"] ?></td>
                                <td><?php echo $row["data_de_nacimento"] ?></td>
                                <td><?php echo $row["password"] ?></td>
                                <td><?php echo $row["role"] ?></td>
                                <td><a href="./editUser.php?id=<?php echo $row['id_user'] ?>"><img src="../imagens/editar.png" alt="edit" style="width: 15px; height: 15px;"></a></td>
                                <td onclick="excluir(<?php echo $row['id_user'] ?>)"><a href="#"><img src="../imagens/lixo.png" alt="delet" style="width: 15px; height: 15px;"></a></td>
                            </tr>
                <?php
                        }
                    }
                ?>  
            </tbody>
        </table>
    </div>
    <script>
        function atualizarFiltro(valor) {
            location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?filtro=" + valor;
        }

        function excluir(id) {
            if (confirm("Tem certeza que deseja excluir este registro?")) {
                location.href = "./deletUser.php?id=" + id;
            }
        }
    </script>
      <script src="../node_modules/jquery/dist/jquery.min.js"></script>
      <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
