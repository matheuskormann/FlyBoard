<?php
    include("../connections/connection.php");

    $email = $_POST["txtemail"];
    $password = $_POST["txtPassword"];

    $sql = "SELECT ID_USER, PASSWORD , ROLE FROM USERS WHERE EMAIL = '$email'
    ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["PASSWORD"] == $password) {
                header("Location:   ../homes/collectorHomes.php");
                session_start();
                $_SESSION["id"] = intval($row["ID_USER"]);
                $_SESSION["role"] = intval($row["ROLE"]);
            }
            else {

?>
<script> 
    history.go(-1);
    alert("Senha Num Ta Certa");
</script>
<?php
            }
        }
    }
    else {
?>
<script>
     history.go(-1);
    alert("Senha Num Ta Certa");
</script>
<?php
    }
?>