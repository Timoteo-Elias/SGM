<?php
    require_once __DIR__ . '/../../config/conexao.php';
    use Model\Usuario;

    class UsuarioDao{


        public function create(Usuario $u) {
            try {
                $sql = "INSERT INTO usuario (nome, email, perfil, senha, imagem) VALUES (?, ?, ?, ?, ?)";
                $stmt = Connect::getConn()->prepare($sql);

                $senhaHash = password_hash($u->getSenha(), PASSWORD_DEFAULT);

                return $stmt->execute([
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
            $sql = "SELECT id_user FROM usuario WHERE email = ?";
            $stmt = Connect::getConn()->prepare($sql);
            $stmt->bindValue(1, $email);
            $stmt->execute();

            // Devolve true se encontrar algum registo, false caso contrário
            return $stmt->rowCount() > 0;
        }

        public function read(){
            $sql = "SELECT * FROM usuario";
            $res = Connect::getConn()->query($sql);
            $usuario = $res->rowCount()>0 ? $res->fetchAll(PDO::FETCH_ASSOC) : [];
            return $usuario;
        }
    }