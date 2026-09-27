<?php
    require_once __DIR__ . '/../../config/conexao.php';
    use Model\Saida;

    class SaidaDao{

        public function create(Saida $saida)
        {
            try {
                $conn = Connect::getConn();

                // 1. Registrar a saída
                $sql = "INSERT INTO saida
                        (cod_saida, id_falecido, id_usuario, nome_receptor, bi_receptor, id_estado)
                        VALUES (?, ?, ?, ?, ?, ?)";

                $res = $conn->prepare($sql);

                $res->execute([
                    $saida->getCodigo(),
                    $saida->getFalecido(),
                    $saida->getUsuario(),
                    $saida->getNomeReceptor(),
                    $saida->getBiReceptor(),
                    $saida->getEstado()
                ]);

                // ID da saída recém-criada
                $idSaida = (int) $conn->lastInsertId();

                if ($idSaida <= 0) {
                    $_SESSION['erro'] = "A saída foi registada, mas não foi possível obter o ID.";
                    return false;
                }

                // 2. Atualizar a entrada
                $entrada = "UPDATE entrada
                            SET id_estado = 9,
                                id_gaveta = NULL
                            WHERE id_falecido = ?";

                $resEntrada = $conn->prepare($entrada);

                $resEntrada->execute([
                    $saida->getFalecido()
                ]);

                // 3. Retornar o ID da saída
                return $idSaida;

            } catch (PDOException $e) {

                $_SESSION['erro'] = "Erro MySQL: " . $e->getMessage();

                return false;
            }
        }
        public function getProximoCodigo() {
            try {
                $sql = "SELECT MAX(id_saida) as ultimo_id FROM saida";
                $stmt = Connect::getConn()->query($sql);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                $proximoId = ($resultado['ultimo_id'] ?? 0) + 1;

                return 'SAI-' . date('Y') . '-'. str_pad($proximoId, 4, '0', STR_PAD_LEFT);
            } catch (PDOException $e) {
                return 'SAI-' . date('Y') . '-0001';
            }
        }
        public function findByCodigo($codigo){
           try{
                $sql = "SELECT * FROM saida WHERE cod_saida = ? ";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->bindValue(1, $codigo);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC); 
            }catch (PDOException $e) {
                return false;
            }
        }

        public function getEstado() {
            $sql = "SELECT * FROM estado WHERE tipo = 'saida' ORDER BY nome ASC";
            $estado = Connect::getConn()->query($sql);
            $estado->execute();
            return $estado->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getFalecido() {
            $sql = "SELECT f.id_falecido, f.nome_completo , e.id_entrada, e.cod_acesso, e.id_gaveta FROM entrada e INNER JOIN falecidos f
            ON e.id_falecido = f.id_falecido WHERE e.id_gaveta IS NOT NULL ORDER BY criado_em ASC";
            $falecido = Connect::getConn()->query($sql);
            $falecido->execute();   
            return $falecido->fetchAll(PDO::FETCH_ASSOC);
        }

        public function read(){
            $sql = "SELECT s.id_saida,s.cod_saida as codigo,s.data_saida as saida, s.nome_receptor as responsavel, f.nome_completo as falecido
            , u.nome as operador, e.nome as estado FROM saida s 
            INNER JOIN falecidos f ON s.id_falecido = f.id_falecido
            INNER JOIN usuario u ON s.id_usuario = u.id_user 
            INNER JOIN estado e ON s.id_estado = e.id_estado ORDER BY s.cod_saida"; 
            $saida = Connect::getConn()->query($sql);
            $saida->execute();
            return $saida->fetchAll(PDO::FETCH_ASSOC);
        }

        public function TotalSaidaHoje(){
            $sql = "SELECT COUNT(*) as total_h FROM saida WHERE DATE(data_saida) = CURDATE()";
            $total = Connect::getConn()->query($sql);
            $total_h = $total->rowCount()>0 ? $total->fetch() : [];
            return $total_h;
        }

        public function delete($codigo){
            try{
                $sql = "DELETE FROM saida WHERE id_saida = ?";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->bindParam(1, $codigo);
                return $stmt->execute();
            } catch (PDOException $e) {
                return false;
            }
        }

        public function getId($id){
            try {
                $sql = "SELECT * FROM saida WHERE id_saida = ?";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->bindParam(1, $id);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC); 
            } catch (PDOException $e) {
                return false;
            }
        }

        public function update(Saida $saida){
            try {
                $sql = "UPDATE saida SET nome_receptor = ?, bi_receptor = ? WHERE id_saida = ?";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->execute([
                    $saida->getNomeReceptor(),
                    $saida->getBiReceptor(),
                    $saida->getIdSaida()
                ]);
                return $stmt->execute();
            } catch (PDOException $e) {
                return false;
            }
        }

         public function FichaById($id){
            $sql = "SELECT
                        s.id_saida,
                        s.cod_saida AS codigo,
                        s.data_saida AS saida,
                        s.nome_receptor as receptor,
                        s.bi_receptor,

                        f.id_falecido,
                        f.nome_completo AS falecido,
                        TIMESTAMPDIFF(YEAR, f.data_nascimento, NOW()) AS idade,
                        f.data_nascimento AS data_nascimento,
                        f.sexo AS sexo,
                        f.estado_civil AS estado_civil,
                        f.nacionalidade AS nacionalidade,
                        f.bi AS bi,
                        f.pai AS pai,
                        f.mae AS mae,
                        f.endereco AS endereco,

                        es.id_estado,
                        es.nome AS estado,

                        u.id_user,
                        u.nome AS operador

                    FROM saida s
                    JOIN falecidos f
                        ON s.id_falecido = f.id_falecido
                    JOIN estado es
                        ON s.id_estado = es.id_estado
                    JOIN usuario u
                        ON s.id_usuario = u.id_user
                    WHERE s.id_saida = ?";

            $stmt = Connect::getConn()->prepare($sql);
            $stmt->execute([$id]);

            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        }

        public function Confi(){
            $sql = "SELECT * FROM config";
            $res = Connect::getConn()->query($sql);
            $res->execute();
            return $res->fetch(PDO::FETCH_ASSOC);
        }

    }