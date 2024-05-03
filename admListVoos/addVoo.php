<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
    exit; 
} 
else if ($_SESSION["role"] != "admin" && $_SESSION["role"] != "funcionario") {
    echo "<script>
            alert('Você não tem permissão!');
            window.history.back();
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
    <title>voos</title>
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

<?php

if (isset($_POST['AdicionarNovoVoo'])) {
    $codigoVoo = $_POST['txtCodigoVoo'];
    $Operadora = $_POST['txtOperadora'];
    $Origem = $_POST['txtOrigem'];
    $Destino = $_POST['txtDestino'];
    $Data_Ida = $_POST['txtData_Ida'];
    $Data_Chegada = $_POST['txtData_Chegada'];
    $Portao_Embarque = $_POST['txtPortao_Embarque'];
    $Aeronave = $_POST['txtAeronave'];
    $CodigoAeronave = $_POST['txtCodigoAeronave'];

    if (isset($_FILES['userImg'])) {
        $voosImg = $_FILES['userImg'];
        if ($voosImg['size'] > 25197152) {
            echo "<script>
                    const ToastRegex = document.getElementById('ToastRegex')
                    const toastBody = ToastRegex.querySelector('.toast-body');
                
                    toastBody.textContent = 'Erro! Arquivo de tamanho maior que o permitido.';
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
            </script>";
        } else {
            $pasta = "../imagens/upload/imagVoos/";
            $nomeVoosImg = $voosImg['name'];
            $novoNomeVoosImg = uniqid("VooImg_".$Destino."-");
            $extensao = strtolower(pathinfo($nomeVoosImg, PATHINFO_EXTENSION));
            $path = $pasta . $novoNomeVoosImg . "." . $extensao;
            $deuCerto = move_uploaded_file($voosImg["tmp_name"], $path);
        }
    }
    else{
        $path = "../imagens/padraoVoos.jpeg";
    }
    
    
    $sql = "INSERT INTO VOOS (CODIGO_VOO, LOCAL_DE_ORIGEM, LOCAL_DE_DESTINO, DATA_IDA, DATA_CHEGADA, PORTAO_EMBARQUE, AERONAVE, CODIGO_AERONAVE, OPERADORA, VOOIMAGEMPATH ) VALUES('$codigoVoo', '$Origem', '$Destino', '$Data_Ida', '$Data_Chegada', '$Portao_Embarque', '$Aeronave', '$CodigoAeronave', '$Operadora', '$path')";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        header("Location: ./listVoos.php?result=successAddVoo");
        exit;
    } else {
        header("Location: ./listVoos.php?result=erro");
        exit;
    }
}
?>

<div id="conteinerButtom">
    <a id="botaoVoltar" type="button" class="btn btn-light" href="./listVoos.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
</div>
<div class="container ">
    <h1>Novo voo</h1>
    <div class="row">
        <div class="col-lg-6">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Adicionar imagem para o voo:</label>
                        <input name="userImg" class="form-control" type="file" id="formFile">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">codigo do voo:</label>
                        <input type="text"  name="txtCodigoVoo" class="form-control" id="exampleFormControlInput1">
                    </div> 
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Origem:</label>
                        <input type="text"  name="txtOrigem" class="form-control" id="exampleFormControlInput1">
                    </div>      
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Destino:</label>
                        <input type="text" name="txtDestino" class="form-control" id="exampleFormControlInput2">
                    </div>
                    <div class="mb-3">
                         <label for="exampleFormControlInput1" class="form-label">Operadoura:</label>
                         <input type="text"  name="txtOperadora" class="form-control" id="exampleFormControlInput1">
                    </div> 
        </div>
        <div class="col-lg-6">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Data de saida:</label>
                    <input type="text" name="txtData_Ida" class="form-control" id="exampleFormControlInput1">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Data de chegada:</label>
                    <input type="text" name="txtData_Chegada" class="form-control" id="exampleFormControlInput1">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Proto de Embarque:</label>
                    <input type="text" name="txtPortao_Embarque" class="form-control" id="exampleFormControlInput1">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Aeronave:</label>
                    <input type="text" name="txtAeronave" class="form-control" id="exampleFormControlInput1">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">codigo Aeronave:</label>
                    <input type="text"  name="txtCodigoAeronave" class="form-control" id="exampleFormControlInput1">
                </div> 
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <!-- Botão Salvar aqui -->
                    <button name="AdicionarNovoVoo" class="btn btn-primary my-auto" type="submit">Salvar</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
