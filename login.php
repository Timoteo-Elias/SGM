<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 1. Primeiro as dependências de base de dados
    require_once __DIR__ . '/App/config/conexao.php';
    require_once __DIR__ . '/App/Model/Dao/UsuarioDao.php'; // Verifique se no disco o "U" é maiúsculo

    // 2. Depois os Controllers
    require_once __DIR__ . '/App/Controller/UsuarioController.php';
    require_once __DIR__ . '/App/Controller/LoginController.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-login'])) {

        $loginController = new LoginController();

        $sucesso = $loginController->login(
            $_POST['email'] ?? '',
            $_POST['senha'] ?? ''
        );

        if ($sucesso) {
            header("Location: App/Views/index.php");
            exit();
        } else {
            header("Location: index.php");
            exit();
        }
    }