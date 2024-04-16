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
 else{
    $id = $_GET["id"];
    $sql = "DELETE FROM USERS WHERE ID_USER = $id";
    $result = $conn->query($sql);

    if ($result === TRUE) {
?>
<script>
function showModal() {
    $('#modal').modal('show');
}
showModal()
location.href = './listUsers.php';
</script>
<?php
    }
    else {
?>
<script>
alert('Algo não deu certo...');
history.go(-1);
</script>
<?php
    }
}
?>
    <script>
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
      <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </script>

<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="labelHeader" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h5>Usuario Deletado Com Sucesso</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>