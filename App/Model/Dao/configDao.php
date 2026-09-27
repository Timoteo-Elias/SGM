<?php
    require_once __DIR__ . '/../../config/conexao.php';
    use Model\Config;

    class ConfigDao{
        public function read(){
            $sql = "SELECT * FROM config";
            $res = Connect::getConn()->query($sql);
            $res->execute();
            return $res->fetch(PDO::FETCH_ASSOC);
        }

        public function update(Config $config) {
            try {
                $sql = "UPDATE config SET nome = ?, telefone = ?, email = ?, dias_permanencia = ?, endereco = ? WHERE id_config = ?";
                $res = Connect::getConn()->prepare($sql);

                return $res->execute([
                    $config->getNome(),
                    $config->getTelefone(),
                    $config->getEmail(),
                    $config->getDiasPermanencia(),
                    $config->getEndereco(),
                    $config->getId()
                ]);
            } catch (\PDOException $e) {
                 echo "Erro MySQL: " . $e->getMessage(); exit();
                return false;
            }
        }
    }