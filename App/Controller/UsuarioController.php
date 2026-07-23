<?php
    use Model\Usuario\Dao;
    use Model\Usuario;
    
    class UsuarioController{
        private $usuarioDao;
        private $usuario;

        public function __construct(){
            $this->usuarioDao = new UsuarioDao();
            $this->usuario = new Usuario();
        }

        public function index(){
            $usuario = $this->usuarioDao->read();
            require_once __DIR__ . '/../Views/usuario.php';
            return $usuario;
        }

        public function insert($nome, $email, $perfil, $senha) {
            try {    
                // 1. Validação de E-mail Duplicado
                if ($this->usuarioDao->findByEmail($email)) {
                    $_SESSION['erro'] = "O e-mail '$email' já está cadastrado no sistema. Utilize outro e-mail.";
                    return false;
                }

                // 2. Validação do Formato do E-mail
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['erro'] = "O e-mail enviado ('" . htmlspecialchars($email) . "') não possui um formato válido!";
                    return false;
                }

                // 3. validação do Tamanho da Senha
                if (strlen($senha) < 4) {
                    $_SESSION['erro'] = "A senha deve ter no mínimo 4 caracteres.";
                    return false;
                }

                // 3. Preencher Dados do Objeto Usuário
                $this->usuario->setNome($nome);
                $this->usuario->setEmail($email);
                $this->usuario->setPerfil($perfil);
                $this->usuario->setSenha($senha);
                
                // 4. Processamento da Imagem (Opcional)
                $nomeImagemFinal = null;

                if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
                    
                    $tmpName      = $_FILES['foto_perfil']['tmp_name'];
                    $nomeOriginal = $_FILES['foto_perfil']['name'];
                    $extensao     = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

                    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

                    if (in_array($extensao, $extensoesPermitidas)) {
                        $nomeImagemFinal = md5(uniqid(rand(), true)) . '.' . $extensao;
                        $pastaDestino    = __DIR__ . '/../uploads/usuarios/';

                        if (!is_dir($pastaDestino)) {
                            mkdir($pastaDestino, 0755, true);
                        }

                        if (!move_uploaded_file($tmpName, $pastaDestino . $nomeImagemFinal)) {
                            $nomeImagemFinal = null;
                        }
                    }
                }

                // Atribui o nome da imagem (seja ele o nome gerado ou null)
                $this->usuario->setImagem($nomeImagemFinal);

                // 5. Salvar no Banco de Dados (AGORA FORA DO IF DA IMAGEM)
                return $this->usuarioDao->create($this->usuario);

            } catch (\PDOException $e) {
                $_SESSION['erro'] = "Erro no banco de dados: " . $e->getMessage();
                return false;
            } catch (\Exception $e) {
                $_SESSION['erro'] = "Erro no sistema: " . $e->getMessage();
                return false;
            }
        }

    }


    