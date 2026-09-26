<?php
    require_once __DIR__ . '/../../config/conexao.php';
    use Model\Estados;

    class EstadosDao{

        public function create(Estados $est) {
            try {
                $sql = "INSERT INTO estado(nome, tipo, descricao) VALUES(?, ?, ?)";
                $res = Connect::getConn()->prepare($sql);

                return $res->execute([
                    $est->getNome(),
                    $est->getTipo(),
                    $est->getDescricao()
                ]);
            } catch (\PDOException $e) {
                 echo "Erro MySQL: " . $e->getMessage(); exit();
                return false;
            }
        }

        public function read() {
            try {
                $sql = "SELECT * FROM estado";
                $stmt = Connect::getConn()->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return false;
            }
        }
        public function findByNome($nome) {
            try {
                $sql = "SELECT * FROM estado WHERE nome = ? LIMIT 1";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->bindValue(1, $nome);
                $stmt->execute();
                
                return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados do estado ou false se não encontrar
            } catch (PDOException $e) {
                return false;
            }
        }

        public function delete($id){
            $sql = "DELETE FROM estado WHERE id_estado = ?";
            $res = Connect::getConn()->prepare($sql);
            $res->bindParam(1, $id);
            $res->execute();
        }

        public function FindId($id){
            $sql = "SELECT * FROM estado WHERE id_estado = $id";
            $res = Connect::getConn()->query($sql);
            $estado = $res->rowCount()>0 ? $res->fetch() : [];
            return $estado;
        }

        public function update(Estados $est){
            try {
                $sql = "UPDATE estado SET nome = ?, tipo = ?, descricao = ? WHERE id_estado = ?";
                $res = Connect::getConn()->prepare($sql);
                return $res->execute([
                    $est->getNome(),
                    $est->getTipo(),
                    $est->getDescricao(),
                    $est->getId()
                ]);
            } catch (\PDOException $e) {
                 echo "Erro MySQL: " . $e->getMessage(); exit();
                return false;
            }
        }
    }