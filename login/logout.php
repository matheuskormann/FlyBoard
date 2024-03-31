<?php
if (!isset($_SESSION["id"])) {
    header("Location: ../login/login.html ");
  }
session_unset();
    
        
session_destroy();
    
        
header("Location:../index/index.php");
exit();
 ?>