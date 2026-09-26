<?php
    include_once(__DIR__ . '/Views/Auth.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/Controller/FalecidoController.php';
    require_once __DIR__ . '/Model/Dao/falecidoDao.php';
    require_once __DIR__ . '/Model/falecido.php';
    require_once __DIR__ . '/config/conexao.php';

    $falecidocontroller = new FalecidoController;

    if(isset($_POST['codigo'])){
        $falecidocontroller->insert(
                trim($_POST['codigo'] ?? ''),
                trim($_POST['nome'] ?? ''),
                trim($_POST['sexo'] ?? ''),
                trim($_POST['obs'] ?? '')
        );

        $_SESSION['sucesso'] = "Ótimo! O registo do falecido foi salvo com sucesso.";

        header("location:views/falecidos.php");
        exit;
    }

    if(isset($_GET['id']) && !empty($_GET['id'])){
        $falecidocontroller->delete($_GET['id']);

        $_SESSION['delete'] = "O registo do falecido foi Eliminado com sucesso.";
        header("location:views/falecidos.php");
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

