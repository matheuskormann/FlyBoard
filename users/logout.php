<?php
  


// Inicia a sessão (se ainda não estiver iniciada)
session_start();

// Remove todas as variáveis de sessão
session_unset();

// Destroi a sessão
session_destroy();

header("Location: ../index/index.php");

