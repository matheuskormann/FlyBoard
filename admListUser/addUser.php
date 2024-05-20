<?php
    include('../connections/connection.php');

    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: ../login/login.php");
        exit; 
    }
    else if ($_SESSION["role"] != "admin") {
        echo "<script>
               location.href = './listUsers.php?result=5';
              </script>";
        exit; 
    }

    $iduser = $_SESSION["id"];
    $sqlNavBar = "SELECT NAME ,EMAIL , ROLE, USERIMAGEPATH FROM USERS WHERE ID_USER = $iduser";
    $resultNavBar = $conn->query($sqlNavBar);
    $rowNavBar = $resultNavBar->fetch_assoc();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuario</title>
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
<nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index/index.php">
          <img src="../imagens/flyboardNavBar.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
          FlyBoard
        </a>
        <div class="pd-10 d-flex justify-content-center"><span>Cadastro De Usuário</span></div>
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
    <div id="botaoVoltar">
       <a type="button" class="btn btn-light" href="./listUsers.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
    </div>
    <form name="form1" id="form1" method="post" action="./addUser_php.php" onsubmit="return validateForm()" style="padding-top: 10%;">

        <div id="conteinercadPasageiro">
            <div class="conteinerInput">
                <div class="container">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-9">
                      <div class="col">
                        <div class=" h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="input">
                                <p>Nome completo:</p>
                                <input id="inputNome" type="text" name="txtName" placeholder="Nome Completo">
                            </div>
                        
                      </div>
                     </div>
                      <div class="col">
                        <div class=" h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="input">
                                <p>CPF:</p>
                                <input id="inputCPF" type="text" name="txtCpf" required placeholder="xxx.xxx.xxx-xx" maxlength="14" oninput="formatarCpf(this)">
                            </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class=" h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="input">
                                <p>Data de Nascimento:</p>
                                <input id="inputDtnasc" type="date" name="txtDtNasc" required>
                            </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="input">
                                <p>E-mail:</p>
                                <input id="inputEmail" type="text" name="txtLogin" required>
                            </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class=" h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="input" id="senha">
                                <p>Senha</p>
                                <input id="inputSenha" type="password" name="txtPassword" required>
                                <h5>A senha deve ter conter 6 caracteres, números e caracter especial</h5>
                            </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="input" id="senha">
                                <p>Confirme a Senha</p>
                                <input id="inputSenha1" type="password" name="txtPassword1" required>
                                <h5>A senha deve ter conter 6 caracteres, números e caracter especial</h5>
                            </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="input" id="role">
                            <p>Role:</p>
                            <select name="selesctRole">
                              <option value="cliente">cliente</option>
                              <option value="funcionario">Funcionario</option>
                              <option value="admin">admin</option>
                            </select>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
            <br>
            <input id="inputEnviar" type="submit" value="Enviar" >
        </div>

    </form>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
<div id="ToastRegex" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>
</div>

    <script>
        function validateForm() {

            var nome = document.forms["form1"]["txtName"].value;
            var email = document.forms["form1"]["txtLogin"].value;
            var password = document.forms["form1"]["txtPassword"].value;
            var confSenha = document.forms["form1"]["txtPassword1"].value;
            var data = document.forms["form1"]["txtDtNasc"].value;

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

            else if (!passwordRegex.test(password)) {
                const ToastRegex = document.getElementById('ToastRegex')
                const toastBody = ToastRegex.querySelector('.toast-body');

                toastBody.textContent = "Senha Inválida, A sua senha deve conter no Minímo 6 Caracteres, 1 Número e 1 Caracter Especial.";
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
                toastBootstrap.show()
                return false;
            }

            else if (confSenha !== password){
                const ToastRegex = document.getElementById('ToastRegex')
                const toastBody = ToastRegex.querySelector('.toast-body');

                toastBody.textContent = "Confirmação Inválida, a confirmação não confere com a senha.";
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
                toastBootstrap.show()
                return false;
            } else {
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
<?php
if (isset($_GET['error'])){
    echo "<script>
    const ToastRegex = document.getElementById('ToastRegex')
    const toastBody = ToastRegex.querySelector('.toast-body');

    toastBody.textContent = 'Erro ao cadastrar usuário, tente novamente.';
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
    toastBootstrap.show()
    </script>";
} else if (isset($_GET['errorEmail'])){
    echo "<script>
    const ToastRegex = document.getElementById('ToastRegex')
    const toastBody = ToastRegex.querySelector('.toast-body');

    toastBody.textContent = 'Email já cadastrado, tente novamente.';
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
    toastBootstrap.show()
    </script>";
} else if (isset($_GET['errorCpf'])){
    echo "<script>
    const ToastRegex = document.getElementById('ToastRegex')
    const toastBody = ToastRegex.querySelector('.toast-body');

    toastBody.textContent = 'CPF já cadastrado, tente novamente.';
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastRegex)
    toastBootstrap.show()
    </script>";
}
?> 
