<?php
    include('../connections/connection.php');
    
    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: ../login/login.php");
        exit; 
    }
    else if ($_SESSION["role"] != "admin") {
        echo "<script>
                alert('Você não tem permissão!');
                window.history.back();
              </script>";
        exit; 
    }
 else{
    $id = $_GET["id"];
    $sql = "DELETE FROM VOOS WHERE ID_VOO = $id";
    $result = $conn->query($sql);

    if ($result === TRUE) {
?>
<script>
location.href = './listVoos.php?result=successDeletVoo';
</script>
<?php
    }
    else {
?>
<script>
location.href = './listVoos.php?result=erro';
</script>
<?php
    }
}
?>