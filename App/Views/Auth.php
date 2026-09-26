<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usuario_logged'])) {
        $_SESSION['erro'] = "Acesso negado. Faça login para continuar.";
        header("Location: /SGM/index.php");
        exit();
    }
?>