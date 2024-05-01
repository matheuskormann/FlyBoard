<?php
    include('../connections/connection.php');

    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: ../login/login.php");
        exit; 
    }
    else if ($_SESSION["role"] == "admin") {
        echo "<script>
                window.location.href = '../index/index.html';
              </script>";
        exit; 
    }
?>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="./addUserStyle.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="../imagens/flyboardLOGOremovido.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<style>
#botaoVoltar{
    
    position: absolute;
    margin: 20px; 
    margin-top: 15px;
}
</style>
<body>
<?php
        $id = $_GET["id"];
        $sql = "SELECT NAME, CPF, EMAIL, DATA_DE_NASCIMENTO, PASSWORD, ROLE FROM USERS WHERE ID_USER = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $name = $row["NAME"];
                $cpf = $row["CPF"];
                $login = $row["EMAIL"];
                $datanascimento = $row["DATA_DE_NASCIMENTO"];
                $password = $row["PASSWORD"];
                $role = $row["ROLE"];
                
            }
        }
    ?>
    <div id="botaoVoltar">
       <a type="button" class="btn btn-light" href="./listUsers.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
    </div>
    <div class="logo"><a href='../index/index.php'><img id="Logo" href='../index/index.php' src="../imagens/flyboardLOGOremovido.png" alt="Logo" ></a></div>
    <div id="h3">
    <h3>Editar Usuário</h3>
    </div>
    <form name="form1" method="post" action="./editUser_php.php" onsubmit="return validateForm()">

        <div id="conteinercadPasageiro">
            <div class="conteinerInput">
                <div class="container">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-9">
                      <div class="col">
                        <div class=" h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="input">
                                <p>Nome completo:</p>
                                <input id="inputNome" type="text" name="txtName" value="<?php echo $name ?>">
                            </div>
                        
                      </div>
                     </div>
                      <div class="col">
                        <div class=" h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="input">
                                <p>CPF:</p>
                                <input id="inputCPF" type="text" name="txtCpf" value="<?php echo $cpf ?>" maxlength="14"oninput="formatarCpf(this)">
                            </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class=" h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="input">
                                <p>Data de Nacimento:</p>
                                <input id="inputDtnasc" type="date" name="txtDtNasc" value="<?php echo $datanascimento ?>">
                            </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="input">
                                <p>E-mail:</p>
                                <input id="inputEmail" type="text" name="txtLogin" value="<?php echo $login ?>">
                            </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="input" id="role">
                            <p>Role:</p>
                            <select name="selesctRole">
                              <option value="<?php echo $role ?>"><?php echo $role ?></option>
                              <option value="cliente">cliente</option>
                              <option value="funcionario">funcionario</option>
                              <option value="admin">admin</option>
                            </select>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
            <br>
            <input type="hidden" name="hidId" value="<?php echo $id ?>">
            <input id="inputEnviar" type="submit" value="Enviar" ">
        </div>

        <!-- toasts -->

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="ToastRegex" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="ToastError" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        Erro ao editar usuário, Tente novamente.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>



    </form>


    <script>
        function validateForm() {

            var nome = document.forms["form1"]["txtName"].value;
            var cpf = document.forms["form1"]["txtCpf"].value;
            var email = document.forms["form1"]["txtLogin"].value;

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            var cpfRegex = /^\d{3}\.?\d{3}\.?\d{3}-?\d{2}$/;

            var nomeRegex = /^[A-Za-z ]{5,}$/;

        if(!nomeRegex.test(nome)){
            const ToastRegex = document.getElementById('ToastRegex')
            const toastBody = ToastRegex.querySelector('.toast-body');
        
            toastBody.textContent = "Nome Inválido, Preencha seu Nome com no mínimo 5 caracteres e somente letras.";
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
            toastBootstrap.show()
            return false;
        }

        else if (!cpfRegex.test(cpf)){
            console.log("cpf")
            const ToastRegex = document.getElementById('ToastRegex')
            const toastBody = ToastRegex.querySelector('.toast-body');
        
            toastBody.textContent = "CPF Inválido, Preencha seu CPF com no máximo 11 caracteres.";
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
            toastBootstrap.show()
            return false;
        }

        else if (!emailRegex.test(email)) {
            const ToastRegex = document.getElementById('ToastRegex')
            const toastBody = ToastRegex.querySelector('.toast-body');
        
            toastBody.textContent = "Email Inválido, Preencha seu Email no formato correto.";
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
            toastBootstrap.show()
            return false;
        }
         else {
            return true;}
        }


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


  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script> 
</body>

</html>