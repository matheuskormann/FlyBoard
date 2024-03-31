<?php
    include("../connections/connection.php");

    $login = $_POST["txtemail"];
    $password = $_POST["txtPassword"];

    $sql = "SELECT id_user, password , role FROM users WHERE login = '$login'
    ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row["password"] == $password) {
                header("Location:   ../homes/collectorHomes.php");
                session_start();
                $_SESSION["id"] = intval($row["id_user"]);
                $_SESSION["role"] = intval($row["role"]);
            }
            else {
?>
<script>
    alert("Senha não confere");
    history.go(-1);
</script>
<?php
            }
        }
    }
    else {
?>
<script>
    alert("Login não confere");
    history.go(-1);
</script>
<?php
    }
?>