<?php
    include('../connections/connection.php');

    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: ../login/login.html  ");
    }
    else if ($_SESSION["role"] == "admin") {
?>
<script>
    alert("Você não tem permissão!");
    header("Location: ../index/index.html ");
</script>
<?php
    }

    $id = $_SESSION["id"];
    $sql = "SELECT name ,login , role FROM users WHERE id_user = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menu.css"> 
    <title>Home</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    
</head>
<body>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <nav id='menu'>
    <input type='checkbox' id='responsive-menu' onclick='updatemenu()'><label></label>
    <ul>
      <li><a href='../index/index.php'>Home</a></li>
      <li><a class='dropdown-arrow'>users</a>
        <ul class='sub-menus'>
          <li><a href='../cliente/cadagagem/cadBagagem.html'>clientes</a></li>
          <li><a href='../cliente/cadagagem/cadBagagem.html'>funconarios</a></li>
        </ul>
      </li>
      <li><a class='dropdown-arrow'>Voos</a>
        <ul class='sub-menus'>
          <li><a href=''>comfiguracao</a></li>
          <li><a href=''>add voos</a></li>
        </ul>
      </li>
      <li><a class='dropdown-arrow'><?php echo $row['name'] ?></a>
        <ul class='sub-menus'>
          <li><a href=''>configurações</a></li>
          <li><a href='../login/logout.php'>logout</a></li>
        </ul>
      </li>
  </nav>
 
  
</body>
</html>
