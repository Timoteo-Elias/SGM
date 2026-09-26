<?php

    include_once(__DIR__ . '/Views/Auth.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/config/conexao.php';
    require_once __DIR__ . '/Model/Config.php';
    require_once __DIR__ . '/Model/Dao/configDao.php';
    require_once __DIR__ . '/Controller/ConfigController.php';

    $configController = new ConfigController(); 


    if(isset($_POST['id_config'])){
            $configController->update(
            trim($_POST['hospital'] ?? ''),
            trim($_POST['telefone'] ?? ''),
            trim($_POST['email'] ?? ''),
            trim($_POST['dias_permanencia'] ?? ''),
            trim($_POST['endereco'] ?? ''),
            trim($_POST['id_config'] ?? '')
        );

       $_SESSION['atualizado'] = "Configurações atualizadas com sucesso.";
        header("Location: Views/config.php");
        exit();
    }
    echo "oi";