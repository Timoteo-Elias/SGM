<?php
// Inclui as dependências necessárias (ajusta os caminhos se necessário)
require_once __DIR__ . '/App/config/conexao.php';
require_once __DIR__ . '/App/Model/Dao/UsuarioDao.php';
require_once __DIR__ . '/App/Controller/LoginController.php';


$loginController = new LoginController();
$loginController->logout();