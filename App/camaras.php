<?php
    include_once(__DIR__ . '/Views/Auth.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/config/conexao.php';
    require_once __DIR__ . '/Model/camara.php';
    require_once __DIR__ . '/Model/Dao/camaraDao.php';
    require_once __DIR__ . '/Controller/CamaraController.php';

    $camaracontroller = new CamaraController();

    if (isset($_POST['codigo'])){
        $sucesso = $camaracontroller->insert(
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
    if (isset($_POST['id_camara'])){
         $camaracontroller->update(
            trim($_POST['capacidade'] ?? ''),
            trim($_POST['temperatura'] ?? ''),
            trim($_POST['estado'] ?? ''), 
            trim($_POST['obs'] ?? ''),
            trim($_POST['id_camara'] ?? '')
        );

       $_SESSION['atualizado'] = "Camara atualizada com sucesso.";
        header("Location: Views/camaras.php");
        exit();
    }
