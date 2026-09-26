<?php
    require_once __DIR__ . '/../../config/conexao.php';
    use Model\Usuario;

    class UsuarioDao{


        public function create(Usuario $u) {
            try {
                $sql = "INSERT INTO usuario (nome, email, perfil, senha, imagem) VALUES (?, ?, ?, ?, ?)";
                $res = Connect::getConn()->prepare($sql);

                $senhaHash = password_hash($u->getSenha(), PASSWORD_DEFAULT);

                return $res->execute([
                    $u->getNome(),
                    $u->getEmail(),
                    $u->getPerfil(),
                    $senhaHash,
                    $u->getImagem()
                ]);

            } catch (PDOException $e) {
                // PARAR A EXECUÇÃO E MOSTRAR O ERRO REAL NA TELA
                echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; font-family: monospace;'>";
                echo "<h3>Erro ao Inserir no MySQL:</h3>";
                echo "<p>" . $e->getMessage() . "</p>";
                echo "</div>";
                exit();
            }
        }
       
        public function findByEmail($email) {
            $sql = "SELECT * FROM usuario WHERE email = ?";
            $res = Connect::getConn()->prepare($sql);
            $res->bindValue(1, $email);
            $res->execute();

            if ($res->rowCount() > 0) {
                return $res->fetch(\PDO::FETCH_ASSOC); // Retorna os dados (id, nome, email, senha, perfil, etc.)
            }

            return false; // Retorna false se não encontrar nenhum e-mail
        }

        public function read(){
            $sql = "SELECT * FROM usuario";
            $res = Connect::getConn()->query($sql);
            $usuario = $res->rowCount()>0 ? $res->fetchAll(PDO::FETCH_ASSOC) : [];
            return $usuario;
        }
    }