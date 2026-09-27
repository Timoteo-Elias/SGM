<?php
    require_once __DIR__ . '/../../config/conexao.php';
    use Model\Depositante;

    class DepositanteDao{
        public function read(){
            $sql = "SELECT * FROM depositante";
            $res = Connect::getConn()->query($sql);
            $res->execute();
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }

        public function create(Depositante $dp) {
            try {
                $sql = "INSERT INTO depositante(nome, bi, telefone, tipo) VALUES(?, ?, ?, ?)";
                $res = Connect::getConn()->prepare($sql);

                return $res->execute([
                    $dp->getNome(),
                    $dp->getBi(),
                    $dp->getTelefone(),
                    $dp->getTipo()
                ]);
            } catch (\PDOException $e) {
                 echo "Erro MySQL: " . $e->getMessage(); exit();
                return false;
            }
        }

        public function findByBi($bi){
           try{
                $sql = "SELECT * FROM depositante WHERE bi = ? ";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->bindValue(1, $bi);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC); 
            }catch (PDOException $e) {
                return false;
            }
        }
        public function findById($id){
           try{
                $sql = "SELECT * FROM depositante WHERE id_depositante = ? ";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->bindValue(1, $id);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC); 
            }catch (PDOException $e) {
                return false;
            }
        }
        public function update(Depositante $dp){
            try{
                $sql = "UPDATE depositante SET nome = ?, bi = ?, telefone = ?, tipo = ? WHERE id_depositante = ?";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->bindValue(1, $dp->getNome());
                $stmt->bindValue(2, $dp->getBi());
                $stmt->bindValue(3, $dp->getTelefone());
                $stmt->bindValue(4, $dp->getTipo());
                $stmt->bindValue(5, $dp->getId());
                return $stmt->execute();
            }catch (PDOException $e) {
                return false;
            }
        }

        public function delete($id){
            try{
                $sql = "DELETE FROM depositante WHERE id_depositante = ?";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->bindParam(1, $id);
                return $stmt->execute();
            }catch (PDOException $e) {
                return false;
            }
        }   
    }