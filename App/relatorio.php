<?php

    include_once(__DIR__ . '/Views/Auth.php');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once __DIR__ . '/config/conexao.php';
    require_once __DIR__ . '/Model/Dao/relatorioDao.php';
    require_once __DIR__ . '/Controller/RelatorioController.php';


    // 1. Ação de limpar o filtro via link (GET)
    if (isset($_GET['limpar'])) {
        unset($_SESSION['resultado_consulta']);
        unset($_SESSION['filtro_ativo']);
        unset($_SESSION['erro']);
        unset($_SESSION['aviso']);
        header("Location: Views/relatorio.php");
        exit();
    }

    // 2. Processa os dados enviados pelo formulário (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tipo'])) {

        $tipo       = trim($_POST['tipo'] ?? '');
        $dataInicio = trim($_POST['data_inicio'] ?? '');
        $dataFim    = trim($_POST['data_fim'] ?? '');

        // Validação de campos obrigatórios
        if (empty($tipo) || empty($dataInicio) || empty($dataFim)) {
            $_SESSION['erro'] = "Preencha todos os campos do filtro.";
            header("Location: Views/relatorio.php");
            exit();
        }
        $relatorioController = new RelatorioController();
        $resultado = $relatorioController->getHistorico($tipo, $dataInicio, $dataFim);
        

        if (!empty($resultado)) {
            // Armazena o resultado e os filtros aplicados na sessão
            $_SESSION['resultado_consulta'] = $resultado;
            $_SESSION['filtro_ativo'] = [
                'tipo'        => $tipo,
                'data_inicio' => $dataInicio,
                'data_fim'    => $dataFim
            ];
            unset($_SESSION['erro']);
            unset($_SESSION['aviso']);
        } else {
            // Se a busca retornar 0 registos
            unset($_SESSION['resultado_consulta']);
            $_SESSION['filtro_ativo'] = [
                'tipo'        => $tipo,
                'data_inicio' => $dataInicio,
                'data_fim'    => $dataFim
            ];
            $_SESSION['aviso'] = "Nenhum registo encontrado para o período selecionado.";
        }

        header("Location: Views/relatorio.php");
        exit();
    }