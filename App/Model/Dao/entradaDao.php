<?php
    require_once __DIR__ . '/../../config/conexao.php';
    use Model\Entrada;

    class EntradaDao{

        public function create(Entrada $entrada)
            {
                try {

                    $conn = Connect::getConn();

                    $sql = "INSERT INTO entrada
                            (cod_acesso, id_falecido, id_usuario, id_depositante, id_gaveta, id_estado)
                            VALUES (?, ?, ?, ?, ?, ?)";

                    $res = $conn->prepare($sql);

                    $res->execute([
                        $entrada->getCodigo(),
                        $entrada->getFalecido(),
                        $entrada->getUsuario(),
                        $entrada->getDepositante(),
                        $entrada->getGaveta(),
                        $entrada->getEstado()
                    ]);

                    // ID da entrada recém-criada
                    $idEntrada = $conn->lastInsertId();

                    // Atualizar capacidade da gaveta
                    $sqlGaveta = "UPDATE gaveta
                                SET capacidade = capacidade - 1
                                WHERE id_gaveta = ?
                                AND capacidade > 0";

                    $stmtGaveta = $conn->prepare($sqlGaveta);

                    $stmtGaveta->execute([
                        $entrada->getGaveta()
                    ]);

                    if ($stmtGaveta->rowCount() === 0) {

                        if ($conn->inTransaction()) {
                            $conn->rollBack();
                        }

                        $_SESSION['erro'] =
                            "A Gaveta selecionada já não possui capacidade disponível!";

                        return false;
                    }

                    // MUITO IMPORTANTE
                    return $idEntrada;

                } catch (PDOException $e) {

                    if ($conn->inTransaction()) {
                        $conn->rollBack();
                    }

                    $_SESSION['erro'] = "Erro MySQL: " . $e->getMessage();

                    return false;
                }
            }

        public function update(Entrada $entrada){
            try {
                $sql = "UPDATE entrada SET id_depositante = ?, id_gaveta = ? WHERE id_entrada = ?";
                $res = Connect::getConn()->prepare($sql);
                return $res->execute([
                    $entrada->getDepositante(),
                    $entrada->getGaveta(),
                    $entrada->getId()
                ]);
               
            }catch (\PDOException $e) {
                 echo "Erro MySQL: " . $e->getMessage(); exit();
                return false;
            }
        }
        public function getById($id){
            $sql = "SELECT e.id_entrada, e.cod_acesso as codigo,f.id_falecido, f.nome_completo as falecido, d.nome as depositante, 
            d.id_depositante, e.data_entrada, g.cod_gaveta as gaveta, g.id_gaveta, es.nome as estado 
            FROM entrada e JOIN falecidos f ON e.id_falecido = f.id_falecido 
            JOIN depositante d ON e.id_depositante = d.id_depositante JOIN gaveta g ON e.id_gaveta = g.id_gaveta 
            JOIN estado es ON e.id_estado = es.id_estado WHERE id_entrada = $id";
            $res = Connect::getConn()->query($sql);
            $falecido = $res->rowCount()>0 ? $res->fetch() : [];
            return $falecido;
        }
        public function getProximoCodigo() {
            try {
                $sql = "SELECT MAX(id_entrada) as ultimo_id FROM entrada";
                $stmt = Connect::getConn()->query($sql);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

                $proximoId = ($resultado['ultimo_id'] ?? 0) + 1;

                return 'ENT-' . date('Y') . '-'. str_pad($proximoId, 4, '0', STR_PAD_LEFT);
            } catch (PDOException $e) {
                return 'ENT-' . date('Y') . '-0001';
            }
        }
        public function findByCodigo($codigo){
           try{
                $sql = "SELECT * FROM entrada WHERE cod_acesso = ? ";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->bindValue(1, $codigo);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC); 
            }catch (PDOException $e) {
                return false;
            }
        }
        public function getEstado() {
            $sql = "SELECT * FROM estado WHERE tipo = 'entrada' ORDER BY nome ASC";
            $estado = Connect::getConn()->query($sql);
            $estado->execute();
            return $estado->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getFalecido() {
            $sql = "SELECT * FROM falecidos  ORDER BY criado_em ASC";
            $falecido = Connect::getConn()->query($sql);
            $falecido->execute();
            return $falecido->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getGavetas() {
            $sql = "SELECT * FROM gaveta  ORDER BY id_gaveta ASC";
            $gaveta = Connect::getConn()->query($sql);
            $gaveta->execute();
            return $gaveta->fetchAll(PDO::FETCH_ASSOC);
        } 
        public function findTotalEntradas() {
            $sql = "SELECT COUNT(*) AS total_g FROM entrada";
            $res = Connect::getConn()->query($sql);
            $total_e = $res->rowCount()>0 ? $res->fetch() : [];
            return $total_e;
        }

        public function gavetasOcupadas($gaveta) {
            $sql = "SELECT COUNT(*) AS total FROM entrada  WHERE id_gaveta = ?";
            $stmt = Connect::getConn()->prepare($sql);
            $stmt->bindValue(1, $gaveta);
            $stmt->execute();
            $ocupada_e = $stmt->fetch(PDO::FETCH_ASSOC);
            return $ocupada_e['total'] ?? 0;
        }
        public function getDepositantes(){
            $sql = "SELECT * FROM depositante ORDER BY nome ASC";
            $dep = Connect::getConn()->query($sql);
            $dep->execute();
            return $dep->fetchAll(PDO::FETCH_ASSOC);
        }

        public function read(){
            $sql = "SELECT e.id_entrada, e.cod_acesso as codigo, f.nome_completo as falecido, d.nome as depositante, e.data_entrada, 
            g.cod_gaveta as gaveta, es.nome as estado FROM entrada e JOIN falecidos f ON e.id_falecido = f.id_falecido 
            JOIN depositante d ON e.id_depositante = d.id_depositante JOIN gaveta g ON e.id_gaveta = g.id_gaveta 
            JOIN estado es ON e.id_estado = es.id_estado";
            $res = Connect::getConn()->query($sql);
            $res->execute();
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }
        public function findGaveta($gaveta) {
            try {
                $sql = "SELECT * FROM gaveta WHERE id_gaveta = ? ";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->bindValue(1, $gaveta);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC); 
            } catch (PDOException $e) {
                return false;
            }
        }

        public function findFalecido($falecido, $estado = 'conservado') {
            try {
                $sql = "SELECT * FROM entrada WHERE id_falecido = ? AND id_estado = (SELECT id_estado FROM estado WHERE nome = ?)";
                $stmt = Connect::getConn()->prepare($sql);
                $stmt->bindValue(1, $falecido);
                $stmt->bindValue(2, $estado);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC); 
            } catch (PDOException $e) {
                return false;
            }
        }

        public function delete($id){
            $sql = "DELETE FROM entrada WHERE id_entrada = ?";
            $res = Connect::getConn()->prepare($sql);
            $res->bindParam(1, $id);
            $res->execute();

        }

        public function EntradasHoje(){
            $sql = "SELECT e.id_entrada, e.cod_acesso as codigo, f.nome_completo as falecido, d.nome as depositante, e.data_entrada, 
            g.cod_gaveta as gaveta, es.nome as estado FROM entrada e JOIN falecidos f ON e.id_falecido = f.id_falecido 
            JOIN depositante d ON e.id_depositante = d.id_depositante JOIN gaveta g ON e.id_gaveta = g.id_gaveta 
            JOIN estado es ON e.id_estado = es.id_estado WHERE DATE(e.data_entrada) = CURDATE()";
            $res = Connect::getConn()->query($sql);
            $res->execute();
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }
        public function TotalEntradaHoje(){
            $sql = "SELECT COUNT(*) as total_h FROM entrada WHERE id_gaveta IS NOT NULL  AND DATE(data_entrada) = CURDATE()";
            $total = Connect::getConn()->query($sql);
            $total_h = $total->rowCount()>0 ? $total->fetch() : [];
            return $total_h;
        }

        public function Conservados(){
            $sql = "SELECT en.cod_acesso as codigo, c.codigo as camara, g.cod_gaveta as gaveta, f.nome_completo as falecido, f.codigo as cod_falecido, 
            d.nome as depositante, e.nome as estado  FROM entrada en INNER JOIN estado e ON en.id_estado = e.id_estado
            INNER JOIN gaveta g ON en.id_gaveta = g.id_gaveta
            INNER JOIN camara c ON g.id_camara = c.id_camara
            INNER JOIN falecidos f ON en.id_falecido = f.id_falecido
            INNER JOIN depositante d ON en.id_depositante = d.id_depositante";
            $result = Connect::getConn()->query($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }

        public function UltimasEntradas(){
            $sql = "SELECT e.id_entrada,e.data_entrada, e.cod_acesso as codigo, f.nome_completo as falecido, d.nome as depositante, e.data_entrada, 
            g.cod_gaveta as gaveta, es.nome as estado FROM entrada e JOIN falecidos f ON e.id_falecido = f.id_falecido 
            JOIN depositante d ON e.id_depositante = d.id_depositante JOIN gaveta g ON e.id_gaveta = g.id_gaveta 
            JOIN estado es ON e.id_estado = es.id_estado ORDER BY e.data_entrada LIMIT 7";
            $res = Connect::getConn()->query($sql);
            $res->execute();
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }

        public function TotalE(){
            $sql = "SELECT COUNT(*) as total_e FROM entrada WHERE id_gaveta > 0";
            $total = Connect::getConn()->query($sql);
            $total_e = $total->rowCount()>0 ? $total->fetch() : [];
            return $total_e;
        }

        public function FichaById($id){
            $sql = "SELECT
                        e.id_entrada,
                        e.cod_acesso AS codigo,
                        e.data_entrada AS emissao,

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

                        d.id_depositante,
                        d.nome AS depositante,
                        d.telefone AS telefone,
                        d.bi AS bi_depositante,
                        d.tipo AS tipo_depositante,


                        g.id_gaveta,
                        g.cod_gaveta AS gaveta,

                        c.id_camara,
                        c.codigo AS camara,

                        es.id_estado,
                        es.nome AS estado,

                        u.id_user,
                        u.nome AS operador

                    FROM entrada e

                    JOIN falecidos f
                        ON e.id_falecido = f.id_falecido

                    JOIN depositante d
                        ON e.id_depositante = d.id_depositante

                    JOIN gaveta g
                        ON e.id_gaveta = g.id_gaveta

                    JOIN camara c
                        ON g.id_camara = c.id_camara

                    JOIN estado es
                        ON e.id_estado = es.id_estado

                    JOIN usuario u
                        ON e.id_usuario = u.id_user

                    WHERE e.id_entrada = ?";

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