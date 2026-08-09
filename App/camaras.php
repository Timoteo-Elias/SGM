<?php
    include_once(__DIR__ . '/Views/Auth.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/Controller/CamaraController.php';
    require_once __DIR__ . '/Model/Dao/camaraDao.php';
    require_once __DIR__ . '/Model/camara.php';
    require_once __DIR__ . '/config/conexao.php';

    $camaractroller = new CamaraController();

    if (isset($_POST['codigo'])){
        $sucesso = $camaractroller->insert(
            trim($_POST['codigo'] ?? ''),
            trim($_POST['capacidade'] ?? ''),
            trim($_POST['temperatura'] ?? ''),
            trim($_POST['estado'] ?? ''), 
            trim($_POST['descricao'] ?? '')
        );

        if ($sucesso) {
            $_SESSION['sucesso'] = "Câmara cadastrada com sucesso!";
        } else {
            if (empty($_SESSION['erro'])) {
                $_SESSION['erro'] = "Não foi possível salvar a câmara. Verifique os dados digitados.";
            }
        }

        header("Location: Views/camaras.php");
        exit();
    }
