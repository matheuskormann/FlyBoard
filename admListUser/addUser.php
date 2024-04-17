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
    <div id="botaoVoltar">
       <a type="button" class="btn btn-light" href="./listUsers.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
    </div>
    <div class="logo"><a href='../index/index.php'><img id="Logo" href='../index/index.php' src="../imagens/flyboardLOGOremovido.png" alt="Logo" ></a></div>
    <div id="h3">
    <h3>Cadastro De Usuário</h3>
    </div>
    <form name="form1" id="form1" method="post" action="./addUser_php.php" onsubmit="return validateForm()">

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
                                <input id="inputCPF" type="text" name="txtCpf" required placeholder="xxx.xxx.xxx-xx" maxlength="14" onkeypress="validarCPF(event)">
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
<div id="ToastError" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      Erro ao cadastrar usuário, Tente novamente.
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
<div id="ToastErrorEmail" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      Email Já Cadastrado.
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>
</div>

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
            var cpf = document.forms["form1"]["txtCpf"].value;
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

        function validarCPF(e) {
            var tecla = e.which || e.keyCode;
            if ((tecla < 48 || tecla > 57) && tecla !== 8 && tecla !== 0 && tecla !== 46 && tecla !== 45) {
                e.preventDefault();
            }
        }
        

        
    </script>


  <script src="../node_modules/jquery/dist/jquery.min.js"></script>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>
<?php
    if (isset($_GET['error'])){
        echo "<script>
        const ToastError = document.getElementById('ToastError')

        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastError)
        toastBootstrap.show()
        </script>";
    } else if (isset($_GET['errorEmail'])){
        echo "<script>
        const ToastErrorEmail = document.getElementById('ToastErrorEmail')

        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(ToastErrorEmail)
        toastBootstrap.show()
        </script>";
    }
?> 
