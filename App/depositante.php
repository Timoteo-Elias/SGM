<?php
    include_once(__DIR__ . '/Views/Auth.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once __DIR__ . '/config/conexao.php';
    require_once __DIR__ . '/Model/Depositante.php';
    require_once __DIR__ . '/Model/Dao/depositanteDao.php';
    require_once __DIR__ . '/Controller/DepositanteController.php';

    $depositanteController = new DepositanteController();

    if(isset($_POST['nome'])){
        $depositanteController->insert(
            trim($_POST['nome'] ?? ''),
            trim($_POST['bi'] ?? ''),
            trim($_POST['telefone'] ?? ''),
            trim($_POST['tipo'] ?? '')
        );

        $_SESSION['sucesso'] = "Ótimo! O registo do depositante foi salvo com sucesso.";

        header("location:views/depositantes.php");
        exit;
    }
    if(isset($_GET['id']) && $_GET['id'] !== ''){
        $depositanteController->delete($_GET['id']);

        $_SESSION['delete'] = "O registo do depositante foi Eliminado com sucesso.";
        header("location:views/depositantes.php");
        exit;
    }
    if(isset($_POST['id_depositante'])){
        $depositanteController->update(
            trim($_POST['id_depositante'] ?? ''),
            trim($_POST['nome_up'] ?? ''),
            trim($_POST['bi_up'] ?? ''),
            trim($_POST['telefone_up'] ?? ''),
            trim($_POST['tipo_up'] ?? '')
        );

        $_SESSION['atualizado'] = "Ótimo! O registo do depositante foi atualizado com sucesso.";

        header("location:views/depositantes.php");
        exit;
    }