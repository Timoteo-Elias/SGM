<?php
    include_once(__DIR__ . '/Views/Auth.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/config/conexao.php';
    require_once __DIR__ . '/Model/Entrada.php';
    require_once __DIR__ . '/Model/Dao/entradaDao.php';
    require_once __DIR__ . '/Controller/EntradaController.php';

    $entradacontroller = new EntradaController();

    if (isset($_POST['codigo'])){
        $sucesso = $entradacontroller->insert(
            trim($_POST['codigo'] ?? ''),
            trim($_POST['falecido'] ?? ''),
            trim($_POST['depositante'] ?? ''),
            trim($_POST['gaveta'] ?? ''),
            trim($_POST['estado'] ?? ''),
            trim($_POST['usuario'] ?? '')
        );

        if ($sucesso) {
            $_SESSION['sucesso'] = "Entrada cadastrada com sucesso!";
        } else {
            if (empty($_SESSION['erro'])) {
                $_SESSION['erro'] = "Não foi possível salvar a entrada. Verifique os dados digitados.";
            }
        }

        header("Location: pdf/ficha_entrada.php?id=" . $idEntrada);
        exit();
    }

    if(isset($_GET['id']) && $_GET['id'] !== ''){
        $entradacontroller->delete($_GET['id']);

        $_SESSION['delete'] = "O registo da entrada foi Eliminado com sucesso.";
        header("location:views/entradas.php");
        exit;
    }

    if(isset($_POST['id_entrada'])){
        $entradacontroller->update(
            trim($_POST['depositante_up'] ?? ''),
            trim($_POST['gaveta_up'] ?? ''),
            trim($_POST['id_entrada'] ?? '')
        );

         $_SESSION['atualizado'] = "O registo do falecido foi atualizado com sucesso.";
        
        header("location:views/entradas.php");
        exit;
    }