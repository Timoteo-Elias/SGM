<?php
    include_once(__DIR__ . '/Views/Auth.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/Controller/GavetasController.php';
    require_once __DIR__ . '/Model/Dao/gavetaDao.php';
    require_once __DIR__ . '/Model/gaveta.php';
    require_once __DIR__ . '/config/conexao.php';

    $gavetacontroller = new GavetaController();

    if (isset($_POST['codigo'])){
        $sucesso = $gavetacontroller->insert(
            trim($_POST['codigo'] ?? ''),
            trim($_POST['capacidade'] ?? ''),
            trim($_POST['estado'] ?? ''), 
            trim($_POST['descricao'] ?? '')
        );

        if ($sucesso) {
            $_SESSION['sucesso'] = "Gaveta cadastrada com sucesso!";
        } else {
            if (empty($_SESSION['erro'])) {
                $_SESSION['erro'] = "Não foi possível salvar a gaveta. Verifique os dados digitados.";
            }
        }

        header("Location: Views/gavetas.php");
        exit();
    }
