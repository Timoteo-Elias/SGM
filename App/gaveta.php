<?php
    include_once(__DIR__ . '/Views/Auth.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/config/conexao.php';
    require_once __DIR__ . '/Model/gaveta.php';
    require_once __DIR__ . '/Model/Dao/gavetaDao.php';
    require_once __DIR__ . '/Controller/GavetasController.php';

    $gavetacontroller = new GavetaController();
    // if($_POST['pesquisa']){
    //     $gavetacontroller->index(
    //         trim($_POST['pesquisa'])
    //     );
    //     header("Location: Views/gavetas.php");
    //     exit();
    // }

    if (isset($_POST['codigo'])){
        $sucesso = $gavetacontroller->insert(
            trim($_POST['codigo'] ?? ''),
            trim($_POST['capacidade'] ?? ''),
            trim($_POST['estado'] ?? ''), 
            trim($_POST['camara'] ?? ''), 
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

    if(isset($_GET['id']) && $_GET['id'] !== ''){
        $gavetacontroller->delete($_GET['id']);
        $_SESSION['delete'] = "O registo da Gaveta foi Eliminado com sucesso.";
        header("Location: Views/gavetas.php");
        exit;
    }

    if(isset($_POST['id_gaveta'])){
        $gavetacontroller->Update(
                trim($_POST['capacidade'] ?? ''),
                trim($_POST['estado'] ?? ''), 
                trim($_POST['camara'] ?? ''), 
                trim($_POST['obs'] ?? ''),
                trim($_POST['id_gaveta'] ?? '')
        );

        $_SESSION['atualizado'] = "O registo da gaveta foi atualizado com sucesso.";
        header("Location: Views/gavetas.php");
        exit;
    }
