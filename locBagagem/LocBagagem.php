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
?><!DOCTYPE html>
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
                    <button type="button" class="btn-close btn-close-white me-2 m-auto buscar" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </html>
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
    <div id="containerButton">
<a id="botaoVoltar" type="button" class="btn btn-light" href="../homes/collectorHomes.php">
    <img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px">
</a>
    
</div>
<div class="container text-center">
    <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3">
        <div class="col">
            <div class="p-3">
                <div class="col">
                    <form method="post">
                        <button type="submit" class="btn btn-primary" name="botao" value="cadastrado">
                            <img src="../imagens/documento-de-aprovacao.png" alt="editar" style="width: 29px; height: 29px; position: relative; bottom: px;"><br>
                            <p>cadastrado</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="p-3">
                <div class="col">
                    <form method="post">
                        <button type="submit" class="btn btn-primary" name="botao" value="despache">
                            <img src="../imagens/pacote.png" alt="editar" style="width: 29px; height: 29px; position: relative; bottom: px;"><br>
                            <p>despachada</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="p-3">
                <div class="col">
                    <form method="post">
                        <button type="submit" class="btn btn-primary" name="botao" value="Passando pela segurança">
                            <img src="../imagens/escudo-do-usuario.png" alt="editar" style="width: 29px; height: 29px; position: relative; bottom: px;"><br>
                            <p>Passando pela segurança</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="p-3">
                <div class="col">
                    <form method="post">
                        <button type="submit" class="btn btn-primary" name="botao" value="Aguardando embarque">
                            <img src="../imagens/caixas.png" alt="editar" style="width: 29px; height: 29px; position: relative; bottom: px;"><br>
                            <p>Aguardando embarque</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="p-3">
                <div class="col">
                    <form method="post">
                        <button type="submit" class="btn btn-primary" name="botao" value="Embarcada">
                            <img src="../imagens/carregamento-de-progresso.png" alt="editar" style="width: 29px; height: 29px; position: relative; bottom: px;"><br>
                            <p>Embarcada</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="p-3">
                <div class="col">
                    <form method="post">
                        <button type="submit" class="btn btn-success" name="botao" value="Em voo">
                            <img src="../imagens/aviao-alt (1).png" alt="editar" style="width: 29px; height: 29px; position: relative; bottom: px;"><br>
                            <p>Em voo</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="p-3">
                <div class="col">
                    <form method="post">
                        <button type="submit" class="btn btn-primary" name="botao" value="Aguardando para desembarque">
                            <img src="../imagens/download-de-progresso.png" alt="editar" style="width: 29px; height: 29px; position: relative; bottom: px;"><br>
                            <p>Aguardando para desembarque</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="p-3">
                <div class="col">
                    <form method="post">
                        <button type="submit" class="btn btn-primary" name="botao" value="Desembarcado / A caminho da esteira">
                            <img src="../imagens/carregamento-de-caminhao.png" alt="editar" style="width: 29px; height: 29px; position: relative; bottom: px;"><br>
                            <p>Desembarcado / A caminho da esteira</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="p-3">
                <div class="col">
                    <form method="post">
                        <button type="submit" class="btn btn-primary" name="botao" value="Entregue">
                            <img src="../imagens/verificar.png" alt="editar" style="width: 29px; height: 29px; position: relative; bottom: px;"><br>
                            <p>Entregue</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="p-3">
                <div class="col">
                    <form method="post">
                        <button type="submit" class="btn btn-danger" name="botao" value="Aguardando retirada">
                            <img src="../imagens/cruz (1).png" alt="editar" style="width: 29px; height: 29px; position: relative; bottom: px;"><br>
                            <p>Aguardando retirada</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
<?php
if (isset($_POST['botao']) || isset($_GET["result"])) {
    $status = ""; // Declare the variable

    if (isset($_POST['botao'])) {
        $status = $_POST['botao'];
        
        
    } elseif (isset($_GET["result"])) {
        $status = $_GET["result"];
    }
    if($status == "cadastrado"){
        ?>
        <h1>Cadastrado:</h1>
            <form method="POST">
                <div class="row">
                    <div class="col-sm-1">
                        <img src="../imagens/codigo-de-barras-lido.png" alt="editar" style="width: 34px; height: 34px; position: relative; left: px;">
                    </div>
                    <div class="col-lg-6">
                        <input type="text" name="bagCodInput" class="form-control mb-3" placeholder="Codigo Bagagem">
                    </div>
                    <div class="col-lg-1">
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                            <button type="submit" name="UpdateLocBagagem"class="btn btn-primary  buscar">submit</button>
                    </div>
                </div>
            </form>
        <?php
    }
    else if($status == "despache"){
        ?>
        <h1>despache:</h1>
            <form method="POST">
                <div class="row">
                    <div class="col-sm-1">
                        <img src="../imagens/codigo-de-barras-lido.png" alt="editar" style="width: 34px; height: 34px; position: relative; left: px;">
                    </div>
                    <div class="col-lg-6">
                                <input type="text" name="bagCodInput" class="form-control mb-3" placeholder="Codigo Bagagem">
                    </div>
                    <div class="col-lg-1">
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                            <button type="submit" name="UpdateLocBagagem"class="btn btn-primary  buscar">submit</button>
                    </div>
                </div>
            </form>
        <?php
    }
    elseif($status == "Passando pela segurança"){
        ?>
        <h1>Passando pela segurança:</h1>
            <form method="POST">
                <div class="row">
                    <div class="col-sm-1">
                        <img src="../imagens/codigo-de-barras-lido.png" alt="editar" style="width: 34px; height: 34px; position: relative; left: px;">
                    </div>
                    <div class="col-lg-6">
                                <input type="text" name="bagCodInput" class="form-control mb-3" placeholder="Codigo Bagagem">
                    </div>
                    <div class="col-lg-1">
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                            <button type="submit" name="UpdateLocBagagem"class="btn btn-primary  buscar">submit</button>
                    </div>
                </div>
            </form>
        <?php
    }
    elseif($status == "Aguardando embarque"){
        ?>
        <h1>Aguardando embarque:</h1>
            <form method="POST">
                <div class="row">
                    <div class="col-sm-1">
                        <img src="../imagens/codigo-de-barras-lido.png" alt="editar" style="width: 34px; height: 34px; position: relative; left: px;">
                    </div>
                    <div class="col-lg-6">
                                <input type="text" name="bagCodInput" class="form-control mb-3" placeholder="Codigo Bagagem">
                    </div>
                    <div class="col-lg-1">
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                            <button type="submit" name="UpdateLocBagagem"class="btn btn-primary  buscar">submit</button>
                    </div>
                </div>
            </form>
        <?php
    }
    elseif($status == "Embarcada"){
        ?>
        <h1>Embarcada:</h1>
            <form method="POST">
                <div class="row">
                    <div class="col-sm-1">
                        <img src="../imagens/codigo-de-barras-lido.png" alt="editar" style="width: 34px; height: 34px; position: relative; left: px;">
                    </div>
                    <div class="col-lg-6">
                                <input type="text" name="bagCodInput" class="form-control mb-3" placeholder="Codigo Bagagem">
                    </div>
                    <div class="col-lg-1">
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                            <button type="submit" name="UpdateLocBagagem"class="btn btn-primary  buscar">submit</button>
                    </div>
                </div>
            </form>
        <?php
    }
    elseif($status == "Em voo"){
        ?>
        <h1>Em voo:</h1>
            <form method="POST">
                <div class="row">
                    <div class="col-sm-1">
                        <img src="../imagens/codigo-de-barras-lido.png" alt="editar" style="width: 34px; height: 34px; position: relative; left: px;">
                    </div>
                    <div class="col-lg-6">
                                <input type="text" name="VooCodInput" class="form-control mb-3" placeholder="Codigo voo">
                    </div>
                    <div class="col-lg-1">
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                            <button type="submit" name="UpdateLocBagagemVoo"class="btn btn-primary  buscar">submit</button>
                    </div>
                </div>
            </form>
        <?php
    }
    elseif($status == "Aguardando para desembarque"){
        ?>
        <h1>Aguardando para desembarque:</h1>
            <form method="POST">
                <div class="row">
                    <div class="col-sm-1">
                        <img src="../imagens/codigo-de-barras-lido.png" alt="editar" style="width: 34px; height: 34px; position: relative; left: px;">
                    </div>
                    <div class="col-lg-6">
                                <input type="text" name="VooCodInput" class="form-control mb-3" placeholder="Codigo voo">
                    </div>
                    <div class="col-lg-1">
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                            <button type="submit" name="UpdateLocBagagemVoo"class="btn btn-primary  buscar">submit</button>
                    </div>
                </div>
            </form>
        <?php
    }
    elseif($status == "Desembarcado / A caminho da esteira"){
        ?>
        <h1>Desembarcado / A caminho da esteira:</h1>
            <form method="POST">
                <div class="row">
                    <div class="col-sm-1">
                        <img src="../imagens/codigo-de-barras-lido.png" alt="editar" style="width: 34px; height: 34px; position: relative; left: px;">
                    </div>
                    <div class="col-lg-6">
                                <input type="text" name="bagCodInput" class="form-control mb-3" placeholder="Codigo Bagagem">
                    </div>
                    <div class="col-lg-1">
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                            <button type="submit" name="UpdateLocBagagem"class="btn btn-primary  buscar">submit</button>
                    </div>
                </div>
            </form>
        <?php
    }
    elseif($status == "Entregue"){
        ?>
        <h1>Entregue:</h1>
            <form method="POST">
                <div class="row">
                    <div class="col-sm-1">
                        <img src="../imagens/codigo-de-barras-lido.png" alt="editar" style="width: 34px; height: 34px; position: relative; left: px;">
                    </div>
                    <div class="col-lg-6">
                                <input type="text" name="bagCodInput" class="form-control mb-3" placeholder="Codigo Bagagem">
                    </div>
                    <div class="col-lg-1">
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                            <button type="submit" name="UpdateLocBagagem"class="btn btn-primary  buscar">submit</button>
                    </div>
                </div>
            </form>
        <?php
    }
    elseif($status == "Aguardando retirada"){
        ?>
        <h1>Aguardando retirada:</h1>
            <form method="POST">
                <div class="row">
                    <div class="col-sm-1">
                        <img src="../imagens/codigo-de-barras-lido.png" alt="editar" style="width: 34px; height: 34px; position: relative; left: px;">
                    </div>
                    <div class="col-lg-6">
                                <input type="text" name="bagCodInput" class="form-control mb-3" placeholder="Codigo Bagagem">
                    </div>
                    <div class="col-lg-1">
                        <input type="hidden" name="status" value="<?php echo $status; ?>">
                            <button type="submit" name="UpdateLocBagagem"class="btn btn-primary  buscar">submit</button>
                    </div>
                </div>
            </form>
        <?php
    }
}
if (isset($_POST['UpdateLocBagagem'])){
    $bagCod = $_POST['bagCodInput'];
    $status = $_POST['status'];
    $sql = "UPDATE BAGAGENS SET STATUS_BAGAGEM = '$status' WHERE CODIGO_BAGAGEM = '$bagCod'";
    $result = $conn->query($sql);
    ?>
    <script>
    location.href = './LocBagagem.php?result=<?php echo $status; ?>';
    </script>
   <?php
}

if (isset($_POST['UpdateLocBagagemVoo'])){
    $codigo_voo = $_POST['VooCodInput'];
    $status = $_POST['status'];
   
$sql_update_bagagens = "UPDATE BAGAGENS B
JOIN PASSAGENS P ON B.FK_PASSAGENS_ID_PASSAGEM = P.ID_PASSAGEM
JOIN VOOS V ON P.FK_VOOS_ID_VOO = V.ID_VOO
SET B.STATUS_BAGAGEM = '$status'
WHERE V.CODIGO_VOO = '$codigo_voo'";

if ($conn->query($sql_update_bagagens) === TRUE) {
echo "Status de todas as bagagens do voo atualizado com sucesso.";
?>
<script>
location.href = './LocBagagem.php?result=<?php echo $status; ?>';
</script>
<?php
} else {
echo "Erro ao atualizar o status das bagagens: " . $conn->error;
}
}

if (isset($_GET["result"])) {
    $result = $_GET["result"];
    if ($result == "success") {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sucesso!</strong> Status da bagagem atualizado.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    } else if ($result == "error") {
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erro!</strong> Não foi possível atualizar o status da bagagem.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
    }

}

?>
</div>