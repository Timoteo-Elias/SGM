<?php
    require_once __DIR__ . '/../../config/conexao.php';
    use Model\Gaveta;

    class GavetaDao{

        public function create(Gaveta $gvt) {
            try {
                $sql = "INSERT INTO gaveta(cod_gaveta, capacidade, estado_id, camara_id, descricao) VALUES(?, ?, ?, ?, ?)";
                $res = Connect::getConn()->prepare($sql);

                return $res->execute([
                    $gvt->getCodigo(),
                    $gvt->getCapacidade(),
                    $gvt->getEstados(),
                    $gvt->getCamaras(),
                    $gvt->getDescricao()
                ]);

                $sqlCamara = "UPDATE camara SET capacidade = capacidade - 1 WHERE id = ? AND capacidade > 0";
        
                $stmtCamara = $this->conn->prepare($sqlCamara);
                $stmtCamara->bindValue(1, $gaveta->getCamaras());
                $stmtCamara->execute();

                // Verificar se a câmara tinha capacidade disponível
                if ($stmtCamara->rowCount() === 0) {
                    // Se a câmara já não tinha vagas, cancela tudo!
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
            $sql = "SELECT * FROM camara ORDER BY codigo ASC";
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
            $sql = "SELECT g.id_gaveta,g.cod_gaveta, g.capacidade, g.descricao, e.nome as estado, c.codigo as camara FROM gaveta g INNER JOIN estado e ON g.estado_id=e.id_estado INNER JOIN camara c ON g.id_camara=c.id_camara";
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

        public function camarasOcupada(){
            $sql = "SELECT COUNT(*) AS ocupada_g FROM gaveta  WHERE capacidade == 0";
            $res = Connect::getConn()->query($sql);
            $ocupada_g = $res->rowCount()>0 ? $res->fetch() : [];
            return $ocupada_g;
        }
    }