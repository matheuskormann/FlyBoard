<?php
    include('../connections/connection.php');
    
    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: ../login/login.php");
        exit; 
    }
    else if ($_SESSION["role"] != "admin") {
        echo "<script>
               location.href = './listBagagens.php?result=semPermissao';
              </script>";
        exit; 
    }
 else{
    $id = $_GET["id"];
    $sql = "DELETE FROM BAGAGENS WHERE ID_BAGAGEM = $id";
    $result = $conn->query($sql);

    if ($result === TRUE) {
?>
<script>
location.href = './listBagagens.php?result=successDeletBagagem';
</script>
<?php
    }
    else {
?>
<script>
location.href = './listBagagens.php?result=erro';
</script>
<?php
    }
}
?>