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
?>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Passageiro</title>
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
        $sql = "SELECT name, cpf, login, data_de_nacimento, password, role FROM users WHERE id_user = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $name = $row["name"];
                $cpf = $row["cpf"];
                $login = $row["login"];
                $datanascimento = $row["data_de_nacimento"];
                $password = $row["password"];
                $role = $row["role"];
                
            }
        }
    ?>
    <div id="botaoVoltar">
       <a type="button" class="btn btn-light" href="../adm/listUsers.php"><img src="../imagens/iconVoltar.png" alt="voltarHome" style="width: 40px; height: 40px"></a>
    </div>
    <div class="logo"><a href='../index/index.php'><img id="Logo" href='../index/index.php' src="../imagens/flyboardLOGOremovido.png" alt="Logo" ></a></div>
    <div id="h3">
    <h3>Editar Usuário</h3>
    </div>
    <form name="form1" method="post" action="./editUser_php.php">

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
                                <input id="inputCPF" type="text" name="txtCpf" value="<?php echo $cpf ?>" maxlength="14" onkeypress="validarCPF(event)">
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
                        <div class=" h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="input" id="senha">
                                <p>Senha</p>
                                <input id="inputSenha" type="password" name="txtPassword" value="<?php echo $password ?>">
                                <h5>A senha deve ter conter 6 caracteres, números e caracter especial</h5>
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
            <input type="hidden" name="hidId" value="<?php echo $id ?>">
            <input id="inputEnviar" type="submit" value="Enviar" ">
        </div>

    </form>


    <script>
        function validateForm() {
            var email = document.forms["form1"]["txtEmail"].value;
            var password = document.forms["form1"]["txtPassword"].value;
            var confSenha = document.forms["form1"]["txtPassword1"].value;
            var cpf = document.forms["form1"]["txtCpf"].value;
            var nome = document.forms["form1"]["txtNome"].value;
            var data = document.forms["form1"]["txtDtNasc"].value;

            

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            var passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            var cpfRegex = /^\d{3}\.?\d{3}\.?\d{3}-?\d{2}$/;

            var nomeRegex = /^\s*$/

            
            if(nomeRegex.test(nome)){
                alert("Preencha o campo nome");
                return false;
            }

            if (!cpfRegex.test(cpf)){
                alert("Preencha somente com números, sem LETRAS");
                return false;
            }

            if (!emailRegex.test(email)) {
                alert("Por favor, Insira um e-mail válido.");
                return false;
            }

            if (!passwordRegex.test(password)) {
                alert("A senha deve ter conter 6 caracteres, números e caracter especial");
                return false;
            }

            if (confSenha !== password){
                alert("A senha deve ter conter 6 caracteres, números e caracter especial");
                return false;
            }
            
            console.log('deu');

            return true;
            
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