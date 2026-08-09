<?php
    require_once __DIR__ . '/../Model/Usuario.php';
    require_once __DIR__ . '/../Model/Dao/usuarioDao.php';

    class LoginController {
        private $usuarioDao;

        public function __construct() {
            $this->usuarioDao = new UsuarioDao();
        }

        public function login($email, $senha) {
            $usuario = $this->usuarioDao->findByEmail($email);

            if (empty($email) || empty($senha)) {
                $_SESSION['erro'] = "Preencha o e-mail e a senha.";
                return false;
            }

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                // Login bem-sucedido
                
                session_regenerate_id(true); // Segurança contra Session Fixation

                $_SESSION['usuario_logged'] = [
                    'id'     => $usuario['id_user'] ?? $usuario['id'],
                    'nome'   => $usuario['nome'],
                    'email'  => $usuario['email'],
                    'perfil' => $usuario['perfil'],
                    'imagem' => $usuario['imagem']
                ];

                return true;
            }

            $_SESSION['erro'] = "E-mail ou senha incorretos!";
            return false;
        }

        public function logout() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // 1. Limpa todas as variáveis de sessão
            $_SESSION = array();

            // 2. Destrói o cookie de sessão do navegador (boa prática de segurança)
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(), 
                    '', 
                    time() - 42000,
                    $params["path"], 
                    $params["domain"],
                    $params["secure"], 
                    $params["httponly"]
                );
            }

            // 3. Destrói a sessão no servidor
            session_destroy();

            // 4. Reinicia uma nova sessão apenas para exibir a mensagem de sucesso
            session_start();
            $_SESSION['sucesso'] = "Sessão encerrada com sucesso!";

            // 5. Redireciona para a página inicial (tela de login)
            header("Location: index.php");
            exit();
        }
    }
?>