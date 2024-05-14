<?php
    include('../connections/connection.php');
    
    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: ../login/login.php");
        exit; 
    }
    else if ($_SESSION["role"] != "admin") {
        echo "<script>
               location.href = './listPassagem.php?result=semPermissao';
              </script>";
        exit; 
    }
 else{
    $id = $_GET["id"];
    $sql = "DELETE FROM PASSAGENS WHERE ID_PASSAGEM = $id";
    $result = $conn->query($sql);

    if ($result === TRUE) {
?>
<script>
location.href = './listPassagem.php?result=successDeletPassagem';
</script>
<?php
    }
    else {
?>
<script>
location.href = './listPassagem.php?result=erro';
</script>
<?php
    }
}
?>