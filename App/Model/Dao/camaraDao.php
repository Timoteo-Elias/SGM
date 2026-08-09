<?php
    require_once __DIR__ . '/../../config/conexao.php';
    use Model\Camara;

    class CamaraDao{

        public function create(Camara $camara) {
            try {
                $sql = "INSERT INTO camara(codigo, capacidade, temperatura, id_estado, obs) VALUES(?, ?, ?, ?, ?)";
                $res = Connect::getConn()->prepare($sql);

                return $res->execute([
                    $camara->getCodigo(),
                    $camara->getCapacidade(),
                    $camara->getTemperatura(),
                    $camara->getEstado(),
                    $camara->getObs()
                ]);
            } catch (\PDOException $e) {
                 echo "Erro MySQL: " . $e->getMessage(); exit();
                return false;
            }
        }   

         public function getProximoCodigo() {
            try {
                $sql = "SELECT MAX(id_camara) as ultimo_id FROM camara";
                $stmt = Connect::getConn()->query($sql);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                $proximoId = ($resultado['ultimo_id'] ?? 0) + 1;

                return 'CAM-' . str_pad($proximoId, 4, '0', STR_PAD_LEFT);
            } catch (PDOException $e) {
                return 'CAM-0001';
            }
        }
        public function findByCodigo($codigo) {
            $sql = "SELECT * FROM camara WHERE codigo = ?";
            $stmt = Connect::getConn()->prepare($sql);
            $stmt->execute([$codigo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getEstado() {
            $sql = "SELECT * FROM estado WHERE tipo = 'camara' ORDER BY nome ASC";
            $estado = Connect::getConn()->query($sql);
            $estado->execute();
            return $estado->fetchAll(PDO::FETCH_ASSOC);
        }

        public function read(){
            $sql = "SELECT c.id_camara, c.codigo, c.capacidade, c.temperatura, e.nome as estado, c.obs, 
            COUNT(g.id_gaveta) AS quantidade_gavetas_criadas,(c.capacidade - COUNT(g.id_gaveta)) AS capacidade_livre 
            FROM camara c LEFT JOIN estado e ON c.id_estado=e.id_estado 
            LEFT JOIN gaveta g ON c.id_camara=g.id_camara
            GROUP BY c.id_camara";
            $camara = Connect::getConn()->query($sql);
            $camara->execute();
            return $camara->fetchAll(PDO::FETCH_ASSOC);
        }
    }