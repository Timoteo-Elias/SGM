<?php
    include_once(__DIR__ . '/Views/Auth.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/config/conexao.php';
    require_once __DIR__ . '/Model/Saida.php';
    require_once __DIR__ . '/Model/Dao/saidaDao.php';
    require_once __DIR__ . '/Controller/SaidaController.php';

    $saidacontroller = new SaidaController();

    if (isset($_POST['codigo'])){
        $sucesso = $saidacontroller->insert(
            trim($_POST['codigo'] ?? ''),
            trim($_POST['falecido'] ?? ''),
            trim($_POST['responsavel'] ?? ''),
            trim($_POST['bi'] ?? ''),
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

        header("Location: pdf/ficha_saida.php?id=" . $idsaida);
        exit();
    }

    if(isset($_GET['delete'])){
        $saidacontroller->delete($_GET['delete']);

        $_SESSION['delete'] = "O registo da saída foi Eliminado com sucesso.";
        header("Location: Views/saidas.php");
        exit();
    }

    if(isset($_POST['id_saida'])){
        $saidacontroller->update(
            trim($_POST['responsavel_up'] ?? ''),
            trim($_POST['bi_up'] ?? ''),
            trim($_POST['id_saida'] ?? '')
        );
        $_SESSION['atualizado'] = "O registo da saída foi atualizado com sucesso.";
        header("Location: Views/saidas.php");
        exit();
    }
