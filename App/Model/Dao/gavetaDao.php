<?php
    require_once __DIR__ . '/../../config/conexao.php';
    use Model\Gaveta;

    class GavetaDao{

        public function create(Gaveta $gvt) {
            try {
                $sql = "INSERT INTO gaveta(cod_gaveta, capacidade, estado_id, id_camara, descricao) VALUES(?, ?, ?, ?, ?)";
                $res = Connect::getConn()->prepare($sql);

                return $res->execute([
                    $gvt->getCodigo(),
                    $gvt->getCapacidade(),
                    $gvt->getEstados(),
                    $gvt->getCamara(),
                    $gvt->getDescricao()
                ]);

                $sqlCamara = "UPDATE camara SET capacidade = capacidade - 1 WHERE id = ? AND capacidade > 0";
        
                $stmtCamara = $this->conn->prepare($sqlCamara);
                $stmtCamara->bindValue(1, $gaveta->getCamaras());
                $stmtCamara->execute();

                // Verificar se a câmara tem capacidade disponível
                if ($stmtCamara->rowCount() === 0) {
                    // Se a câmara já não tem vagas, cancela tudo!
                    $this->conn->rollBack();
                    $_SESSION['erro'] = "A câmara selecionada já não possui capacidade disponível!";
                    return false;
                }
            } catch (\PDOException $e) {
                 echo "Erro MySQL: " . $e->getMessage(); exit();
                return false;
            }
        }

        public function findByCodigo($codigo) {
            try {
                $sql = "SELECT * FROM gaveta WHERE cod_gaveta = ? LIMIT 1";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->bindValue(1, $codigo);
                $stmt->execute();
                
                return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados da gaveta ou false se não encontrar
            } catch (PDOException $e) {
                return false;
            }
        }

        public function getProximoCodigo() {
            try {
                $sql = "SELECT MAX(id_gaveta) as ultimo_id FROM gaveta";
                $stmt = Connect::getConn()->query($sql);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                $proximoId = ($resultado['ultimo_id'] ?? 0) + 1;

                return 'GVT-' . str_pad($proximoId, 4, '0', STR_PAD_LEFT);
            } catch (PDOException $e) {
                return 'GVT-0001';
            }
        }

        public function getCamaras() {
            $sql = "SELECT c.codigo, c.id_camara, e.nome FROM camara c 
            INNER JOIN estado e ON c.id_estado = e.id_estado
            WHERE e.nome = 'operacional' ORDER BY codigo ASC";
            $camaras = Connect::getConn()->query($sql);
            $camaras->execute();
            return $camaras->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getEstado() {
            $sql = "SELECT * FROM estado WHERE tipo = 'gaveta' ORDER BY nome ASC";
            $estado = Connect::getConn()->query($sql);
            $estado->execute();
            return $estado->fetchAll(PDO::FETCH_ASSOC);
        }

        public function read(){
            $sql = "SELECT g.id_gaveta,g.cod_gaveta, g.capacidade, g.descricao, e.nome as estado, c.codigo as camara FROM gaveta g 
            INNER JOIN estado e ON g.estado_id=e.id_estado INNER JOIN camara c ON g.id_camara=c.id_camara";
            $res = Connect::getConn()->query($sql);
            $gavetas =$res->rowCount() > 0 ? $res ->fetchAll(PDO::FETCH_ASSOC) : []; 
            return $gavetas;
        }
        public function readTotal(){
            $sql = "SELECT COUNT(*) AS total_g FROM gaveta";
            $res = Connect::getConn()->query($sql);
            $total_g = $res->rowCount()>0 ? $res->fetch() : [];
            return $total_g;
        }

        public function camarasOcupada($camara){
            $sql = "SELECT COUNT(*) AS total FROM gaveta  WHERE id_camara = ?";
            $stmt = Connect::getConn()->prepare($sql);
            $stmt->bindValue(1, $camara);
            $stmt->execute();
            $ocupada_g = $stmt->fetch(PDO::FETCH_ASSOC);
            return $ocupada_g['total'] ?? 0;
        }
        public function findById($camara) {
            try {
                $sql = "SELECT * FROM camara WHERE id_camara = ? ";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->bindValue(1, $camara);
                $stmt->execute();
                
                return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados da câmara ou false se não encontrar
            } catch (PDOException $e) {
                return false;
            }
        }
        public function getId($id){
            try {
                $sql = "SELECT * FROM gaveta WHERE id_gaveta = $id";
                $res = Connect::getConn()->query($sql);
                $gaveta = $res->rowCount()>0 ? $res->fetch() : [];
                return $gaveta;
            } catch (PDOException $e) {
                return false;
            }
        }

        public function delete($id){
            $sql = "DELETE FROM gaveta WHERE id_gaveta = ?";
            $res = Connect::getConn()->prepare($sql);
            $res->bindParam(1, $id);
            $res->execute();
        }

        public function update(Gaveta $gvt){
            $sql = "UPDATE gaveta SET capacidade = ?, estado_id = ?, id_camara = ?, descricao = ? WHERE id_gaveta = ?";
            $res = Connect::getConn()->prepare($sql);
            return $res->execute([
                    $gvt->getCapacidade(),
                    $gvt->getEstados(),
                    $gvt->getCamara(),
                    $gvt->getDescricao(),
                    $gvt->getId()
                ]);
        }

        public function gavetasOcupadas() {
            $sql = "SELECT COUNT(*) AS total FROM gaveta  WHERE capacidade = 0 ";
            $res = Connect::getConn()->query($sql);
            $total_o = $res->rowCount()>0 ? $res->fetch() : [];
            return $total_o;
        }
        public function gavetasDisponivel() {
            $sql = "SELECT COUNT(*) AS total FROM gaveta  WHERE capacidade > 0 ";
            $res = Connect::getConn()->query($sql);
            $total_D = $res->rowCount()>0 ? $res->fetch() : [];
            return $total_D;
        }
    }