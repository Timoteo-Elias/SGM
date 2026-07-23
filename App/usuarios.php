<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/Controller/UsuarioController.php';
    require_once __DIR__ . '/Model/Dao/usuarioDao.php';
    require_once __DIR__ . '/Model/usuario.php';
    require_once __DIR__ . '/config/conexao.php';

    $usuariocontroller = new UsuarioController;

    if (isset($_POST['usuario'])) {

        $salvou = $usuariocontroller->insert(
            trim($_POST['usuario'] ?? ''),
            trim($_POST['email'] ?? ''),
            trim($_POST['perfil'] ?? ''),
            trim($_POST['senha'] ?? '')
            
        );

        if ($sucesso) {
        $_SESSION['sucesso'] = "Usuário cadastrado com sucesso!";
    } else {
        // CORREÇÃO AQUI: Se o Controller já guardou uma mensagem de erro específica
        // (como formato inválido ou e-mail duplicado), mantemos essa mensagem.
        // Só usamos a mensagem genérica se a $_SESSION['erro'] estiver VAZIA.
        if (empty($_SESSION['erro'])) {
            $_SESSION['erro'] = "Não foi possível salvar o usuário. Verifique os dados digitados.";
        }
    }

        header("Location: views/usuario.php");
        exit();
    }
  

