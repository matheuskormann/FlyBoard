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
location.href = './listUsers.php?result=1';
</script>
<?php
    }
    else {
?>
<script>
location.href = './listUsers.php?result=2';
</script>
<?php
    }
}
?>