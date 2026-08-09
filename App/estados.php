<?php
    include_once(__DIR__ . '/Views/Auth.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once __DIR__ . '/Controller/EstadosController.php';
    require_once __DIR__ . '/Model/Dao/estadosDao.php'; 
    require_once __DIR__ . '/Model/estados.php';
    require_once __DIR__ . '/config/conexao.php';

    $estadosController = new EstadosController();

    if(isset($_POST['nome'])){
        $estadosController->insert(
                trim($_POST['nome'] ?? ''),
                trim($_POST['tipo'] ?? ''),
                trim($_POST['descricao'] ?? '')
        );

        $_SESSION['sucesso'] = "Ótimo! O registo do estado foi salvo com sucesso.";

        header("location:views/estados.php");
        exit;
    }