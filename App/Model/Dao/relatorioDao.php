<?php 
require_once __DIR__ . '/../../config/conexao.php';

class RelatorioDao {
    public function getPermanenciaAtual() {
        try {
            $sql = "SELECT 
                        e.cod_acesso AS entrada, 
                        f.nome_completo AS falecido, 
                        f.bi, 
                        CONCAT(COALESCE(c.codigo, 'S/C'), ' (', COALESCE(g.cod_gaveta, 'S/G'), ')') AS gaveta, 
                        DATE_FORMAT(e.data_entrada, '%d/%m/%Y %H:%i') AS data_formatada, 
                        DATEDIFF(NOW(), e.data_entrada) AS dias_morgue 
                    FROM entrada e 
                    INNER JOIN falecidos f ON e.id_falecido = f.id_falecido
                    LEFT JOIN gaveta g ON e.id_gaveta = g.id_gaveta 
                    LEFT JOIN camara c ON g.id_camara = c.id_camara
                    WHERE e.id_gaveta IS NOT NULL 
                      AND e.id_gaveta != ''
                    ORDER BY e.data_entrada ASC";

            $stmt = Connect::getConn()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            if (session_status() === PHP_SESSION_NONE) { session_start(); }
            $_SESSION['erro'] = "Erro ao buscar relatorio de permanencia: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Histórico de Entradas por Período
     */
    public function getEntradasPorPeriodo($dataInicio, $dataFim) {
        try {
                $sql = "SELECT 
                        e.id_entrada, 
                        e.cod_acesso AS entrada, 
                        f.nome_completo AS falecido, 
                        f.bi,  
                        CONCAT(
                        COALESCE(c.codigo, 'S/C'),
                        ' (',
                        COALESCE(g.cod_gaveta, 'S/G'),
                        ')'
                        ) AS gaveta,
                        DATE_FORMAT(e.data_entrada, '%d/%m/%Y %H:%i') AS data_formatada,
                        COALESCE(u.nome, 'N/A') AS operador
                    FROM entrada e
                    INNER JOIN falecidos f ON e.id_falecido = f.id_falecido
                    INNER JOIN gaveta g ON e.id_gaveta = g.id_gaveta
                    INNER JOIN camara c ON g.id_camara = c.id_camara
                    LEFT JOIN usuario u ON e.id_usuario = u.id_user
                    WHERE DATE(e.data_entrada) BETWEEN :data_inicio AND :data_fim
                    ORDER BY e.data_entrada DESC";

            $stmt = Connect::getConn()->prepare($sql);

            $stmt->bindValue(':data_inicio', $dataInicio);
            $stmt->bindValue(':data_fim', $dataFim);

            $stmt->execute();
            
           
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['erro'] =
            "Erro ao buscar entradas: " . $e->getMessage();

        return [];
    }
}

    /**
     * Histórico de Saídas por Período
     */
    public function getSaidasPorPeriodo($dataInicio, $dataFim) {
        try {
            $sql = "SELECT 
            
                        s.id_saida, 
                        s.cod_saida AS saida,
                        e.cod_acesso AS entrada, 
                        f.nome_completo AS falecido, 
                        f.bi, 
                        DATE_FORMAT(s.data_saida, '%d/%m/%Y %H:%i') AS data_formatada,
                        COALESCE(u.nome, 'N/A') AS operador
                    FROM saida s
                    INNER JOIN entrada e ON e.id_falecido = s.id_falecido
                    INNER JOIN falecidos f ON e.id_falecido = f.id_falecido
                    LEFT JOIN usuario u ON e.id_usuario = u.id_user
                    WHERE DATE(s.data_saida) BETWEEN :data_inicio AND :data_fim
                    ORDER BY s.data_saida DESC";

            $stmt = Connect::getConn()->prepare($sql);
            $stmt->bindValue(':data_inicio', $dataInicio);
            $stmt->bindValue(':data_fim', $dataFim);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            if (session_status() === PHP_SESSION_NONE) { session_start(); }
            $_SESSION['erro'] = "Erro ao buscar saídas: " . $e->getMessage();
            return [];
        }
    }

}