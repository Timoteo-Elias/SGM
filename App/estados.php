<?php
    include_once(__DIR__ . '/Views/Auth.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once __DIR__ . '/config/conexao.php';
    require_once __DIR__ . '/Model/estados.php';
    require_once __DIR__ . '/Model/Dao/estadosDao.php'; 
    require_once __DIR__ . '/Controller/EstadosController.php';

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

    if(isset($_GET['id']) && $_GET['id'] !== ''){
        $estadosController->delete($_GET['id']);

        $_SESSION['delete'] = "O registo do estado foi Eliminado com sucesso.";
        header("location:views/estados.php");
        exit;
    }

    if(isset($_POST['id_estado'])){
        $estadosController->Update(
                trim($_POST['nome_up'] ?? ''),
                trim($_POST['tipo_up'] ?? ''),
                trim($_POST['descricao_up'] ?? ''),
                trim($_POST['id_estado'] ?? '')
        );

        $_SESSION['atualizado'] = "Ótimo! O registo do estado foi atualizado com sucesso.";

        header("location:views/estados.php");
        exit;
    }

    if(isset($_POST['id_falecido'])){
        $falecidocontroller->Update(
                trim($_POST['codigo_up'] ?? ''),
                trim($_POST['nome_up'] ?? ''),
                trim($_POST['sexo_up'] ?? ''),
                trim($_POST['obs_up'] ?? ''),
                trim($_POST['id_falecido'] ?? '')
        );

        $_SESSION['atualizado'] = "O registo do falecido foi atualizado com sucesso.";
        
        header("location:views/falecidos.php");
        exit;
    }