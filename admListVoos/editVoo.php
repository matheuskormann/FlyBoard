<?php
include('../connections/connection.php');

session_start();
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.php");
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
 $sql = "SELECT ID_VOO, CODIGO_VOO, DESTINO, DATA_IDA, DATA_CHEGADA, PORTAO_EMBARQUE, AERONAVE, OPERADORA, VOOIMAGEMPATH FROM VOOS WHERE ID_VOO = $id";
 $result = $conn->query($sql);
 if ($result->num_rows > 0) {
     while($row = $result->fetch_assoc()) {
         $CODIGO_VOO = $row["CODIGO_VOO"];
         $DESTINO = $row["DESTINO"];
         $DATA_IDA = $row["DATA_IDA"];
         $DATA_CHEGADA = $row["DATA_CHEGADA"];
         $PORTAO_EMBARQUE = $row["PORTAO_EMBARQUE"];
         $AERONAVE = $row["AERONAVE"];
         $OPERADORA = $row["OPERADORA"];
         $atualVooImagePath = $row["VOOIMAGEMPATH"];
     }
 }

if (isset($_POST['atualizarDados'])) {
    if (isset($_FILES['userImg'])) {
        $voosImg = $_FILES['userImg'];
        if ($voosImg['size'] > 25197152) {
            echo "<script>alert('Arquivo muito grande!');</script>";
        } else {
            if (file_exists($atualVooImagePath) && $atualVooImagePath != "../imagens/padraoVoos.jpeg") {
                if (!unlink($atualVooImagePath)) {
                    echo "<script>
                    const ToastRegex = document.getElementById('ToastRegex')
                    const toastBody = ToastRegex.querySelector('.toast-body');
                
                    toastBody.textContent = 'Falha ao atualizar a imagem, Tente novamente.';
                    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
                    toastBootstrap.show()
                    </script>";
                }
            }

            $pasta = "../imagens/upload/imagVoos/";
            $nomeVoosImg = $voosImg['name'];
            $novoNomeVoosImg = uniqid("VooImg_".$DESTINO."-");
            $extensao = strtolower(pathinfo($nomeVoosImg, PATHINFO_EXTENSION));
            $path = $pasta . $novoNomeVoosImg . "." . $extensao;
            $deuCerto = move_uploaded_file($voosImg["tmp_name"], $path);

            if ($deuCerto) {
                $sqlUploadImg = "UPDATE VOOS SET VOOIMAGEMPATH = '$path' WHERE ID_VOO = $id";
                $result = $conn->query($sqlUploadImg);
            }
        }
    }
}

if (isset($_POST['atualizarDados'])) {
    $editDestino = $_POST['txtDestino'];
    $editData_Ida = $_POST['txtData_Ida'];
    $editData_Chegada = $_POST['txtData_Chegada'];
    $editPortao_Embarque = $_POST['txtPortao_Embarque'];
    $editAeronave = $_POST['txtAeronave'];
    $id = $_GET["id"];
    
    // Usando consulta preparada para prevenir SQL Injection
    $sql2 = "UPDATE VOOS SET DESTINO = ?, DATA_IDA = ?, DATA_CHEGADA = ?, PORTAO_EMBARQUE = ?, AERONAVE = ? WHERE ID_VOO = ?";
    $stmt = $conn->prepare($sql2);
    $stmt->bind_param('sssssi', $editDestino, $editData_Ida, $editData_Chegada, $editPortao_Embarque, $editAeronave, $id);
    
    if ($stmt->execute()) {
        echo "<script>
        window.location.href = './listVoos.php?result=successDataUpdate';
        </script>";
    } else {
        echo "<script>
        const ToastRegex = document.getElementById('ToastRegex');
        const toastBody = ToastRegex.querySelector('.toast-body');
        toastBody.textContent = 'Falha ao atualizar o voo, tente novamente.';
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
        <a id="botaoVoltar" type="button" class="btn btn-light" href="./listVoos.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                    <table class="table  table-borderless" id="conteinerDadados">
                       <tr>
                        <th class="" scope="row">codigo:</th>
                        <td ><?php echo $CODIGO_VOO ?></td>
                       </tr>
                       <tr>
                         <th class="" scope="row">Operadoura:</th>
                         <td ><?php echo $OPERADORA ?></td>
                        </tr>
                    </table>
                <h1>Imagem</h1>
                <div class="">
                    <div>
                        <div id="comtImgUser">
                            <img height="175px" id="userImg" src="<?php echo $atualVooImagePath ?>" alt="">
                        </div>
                        <div>
                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Alterar imagem de perfil:</label>
                                    <input name="userImg" class="form-control" type="file" id="formFile">
                                </div>
                                <br>
                            
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <h1>Dados</h1>

                
                    <!-- <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Origem:</label>
                        <input type="text"  name="txtName" class="form-control" id="exampleFormControlInput1" value="<?php echo $Origem ?>">
                    </div>       -->
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Destino:</label>
                        <input type="txt" name="txtDestino" class="form-control" id="exampleFormControlInput2" value="<?php echo $DESTINO ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Data de saida:</label>
                        <input type="txt" name="txtData_Ida" class="form-control" id="exampleFormControlInput1" value="<?php echo $DATA_IDA ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Data de chegada:</label>
                        <input type="txt" name="txtData_Chegada" class="form-control" id="exampleFormControlInput1" value="<?php echo $DATA_CHEGADA ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Proto de Embarque:</label>
                        <input type="txt" name="txtPortao_Embarque" class="form-control" id="exampleFormControlInput1" value="<?php echo $PORTAO_EMBARQUE ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Aeronave:</label>
                        <input type="txt" name="txtAeronave" class="form-control" id="exampleFormControlInput1" value="<?php echo $AERONAVE ?>">
                    </div>
                    <button name="atualizarDados" class="btn btn-primary mb-3" type="submit">Salvar</button>
                </form>
            </div>
        </div>
    </div>
    
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
